/* ================================================================
   NOIRWERK — main.js
================================================================ */

(() => {
    'use strict';

    
    /* ---------- DOOM GAME ---------- */
    let Doom = (() => {
        const RAW = [
            "##############",
            "#P...#...a..E#",
            "#.##.#.#####.#",
            "#.#..E....#..#",
            "#.#.####..#.h#",
            "#......#..#..#",
            "###.##.#.###.#",
            "#E..#..#.....#",
            "#.###.####.###",
            "#....E...#..E#",
            "#.#####..#...#",
            "#.#...#.h#.a.#",
            "#...E.#....#E#",
            "##############"
        ];
        const W = 320,
            H = 200,
            FOV = .66;
        let cv, ctx, open = false,
            state = 'boot',
            p, enemies, pickups, zbuf = new Float32Array(W),
            tex = {},
            sprImp, sprHurt, sprHp, sprAmmo;
        let keys = {},
            lastShot = 0,
            flashT = 0,
            dmgT = 0,
            msg = '',
            msgT = 0,
            walkC = 0,
            recoil = 0,
            last = 0,
            raf = 0;

        function mkTex(fn) { const c = document.createElement('canvas');
            c.width = c.height = 64;
            fn(c.getContext('2d')); return c; }

        function buildAssets() {
            tex.wall = mkTex(g => {
                g.fillStyle = '#0d0d0d';
                g.fillRect(0, 0, 64, 64);
                g.fillStyle = '#1d1d1d';
                for (let y = 0; y < 64; y += 16) { g.fillRect(0, y, 64, 1); for (let x = (y / 16 % 2) * 16; x < 64; x += 32) g.fillRect(x, y, 1, 16); }
                for (let i = 0; i < 140; i++) { g.fillStyle = `rgba(255,255,255,${Math.random()*.06})`;
                    g.fillRect(Math.random() * 64 | 0, Math.random() * 64 | 0, 1, 1); }
                g.fillStyle = 'rgba(214,0,28,.7)';
                g.fillRect(30, 26, 3, 3);
            });
            tex.panel = mkTex(g => {
                g.fillStyle = '#101010';
                g.fillRect(0, 0, 64, 64);
                for (let x = 0; x < 64; x += 16) { g.fillStyle = '#060606';
                    g.fillRect(x, 0, 2, 64);
                    g.fillStyle = '#1a1a1a';
                    g.fillRect(x + 2, 0, 1, 64); }
                g.fillStyle = '#D6001C';
                g.fillRect(0, 40, 64, 2);
                g.fillStyle = 'rgba(214,0,28,.25)';
                g.fillRect(0, 42, 64, 4);
            });
            sprImp = mkImp(false);
            sprHurt = mkImp(true);
            sprHp = mkTex(g => {
                g.fillStyle = '#e8e8e8';
                g.fillRect(3, 7, 10, 7);
                g.fillStyle = '#0a0a0a';
                g.fillRect(3, 12, 10, 2);
                g.fillStyle = '#D6001C';
                g.fillRect(7, 8, 2, 5);
                g.fillRect(6, 9, 4, 2);
            });
            sprAmmo = mkTex(g => {
                g.fillStyle = '#141414';
                g.fillRect(3, 8, 10, 6);
                g.fillStyle = '#D6001C';
                g.fillRect(3, 8, 10, 1);
                g.fillStyle = '#fff';
                g.fillRect(5, 10, 1, 3);
                g.fillRect(8, 10, 1, 3);
                g.fillRect(11, 10, 1, 3);
            });
        }

        function mkImp(hurt) {
            return mkTex(g => {
                const B = '#151515',
                    E = '#fff',
                    R = '#D6001C';
                g.fillStyle = hurt ? '#3a0508' : B;
                g.fillRect(4, 6, 8, 9);
                g.fillRect(5, 2, 6, 5);
                g.fillRect(3, 7, 1, 4);
                g.fillRect(12, 7, 1, 4);
                g.fillRect(5, 14, 2, 2);
                g.fillRect(9, 14, 2, 2);
                g.fillStyle = '#2c2c2c';
                g.fillRect(4, 1, 1, 2);
                g.fillRect(11, 1, 1, 2);
                g.fillStyle = E;
                g.fillRect(6, 4, 1, 1);
                g.fillRect(9, 4, 1, 1);
                g.fillStyle = R;
                g.fillRect(7, 6, 2, 1);
                g.fillRect(3, 11, 1, 1);
                g.fillRect(12, 11, 1, 1);
            });
        }

        function reset() {
            enemies = [];
            pickups = [];
            RAW.forEach((row, y) => [...row].forEach((ch, x) => {
                if (ch === 'P') p = { x: x + .5, y: y + .5, a: 0, hp: 100, ammo: 24, score: 0 };
                if (ch === 'E') enemies.push({ x: x + .5, y: y + .5, hp: 3, dead: false, deathT: 0, pain: 0, last: 0 });
                if (ch === 'h') pickups.push({ x: x + .5, y: y + .5, t: 'hp' });
                if (ch === 'a') pickups.push({ x: x + .5, y: y + .5, t: 'am' });
            }));
            msg = '';
            flashT = 0;
            dmgT = 0;
            recoil = 0;
        }
        const cell = (x, y) => { const r = RAW[y | 0]; return r ? (r[x | 0] || '#') : '#'; };
        const solid = (x, y) => { const c = cell(x, y); return c === '#' || c === '='; };
        const blocked = (x, y, r = .22) => solid(x - r, y - r) || solid(x + r, y - r) || solid(x - r, y + r) || solid(x + r, y + r);

        function los(x0, y0, x1, y1) {
            const d = Math.hypot(x1 - x0, y1 - y0),
                s = Math.ceil(d / .1);
            for (let i = 1; i < s; i++) { const t = i / s; if (solid(x0 + (x1 - x0) * t, y0 + (y1 - y0) * t)) return false; }
            return true;
        }

        function rayDist(ang) { const dx = Math.cos(ang),
                dy = Math.sin(ang); let d = 0; while (d < 20) { d += .05; if (solid(p.x + dx * d, p.y + dy * d)) break; } return d; }

        function cam(sx, sy) {
            const rx = sx - p.x,
                ry = sy - p.y,
                dX = Math.cos(p.a),
                dY = Math.sin(p.a);
            const plX = -dY * FOV,
                plY = dX * FOV,
                inv = 1 / (plX * dY - dX * plY);
            return { tx: inv * (dY * rx - dX * ry), ty: inv * (-plY * rx + plX * ry) };
        }

        let AC = null;
        const ac = () => AC = AC || new(window.AudioContext || window.webkitAudioContext)();

        function blip(f0, f1, t, v, type = 'square') { try { const c = ac(),
                    o = c.createOscillator(),
                    g = c.createGain(),
                    n = c.currentTime;
                o.type = type;
                o.frequency.setValueAtTime(f0, n);
                o.frequency.exponentialRampToValueAtTime(Math.max(20, f1), n + t);
                g.gain.setValueAtTime(v, n);
                g.gain.exponentialRampToValueAtTime(.001, n + t);
                o.connect(g).connect(c.destination);
                o.start(n);
                o.stop(n + t);
            } catch (e) {} }

        function burst(t, v) { try { const c = ac(),
                    b = c.createBuffer(1, c.sampleRate * t | 0, c.sampleRate),
                    d = b.getChannelData(0);
                for (let i = 0; i < d.length; i++) d[i] = (Math.random() * 2 - 1) * (1 - i / d.length);
                const s = c.createBufferSource(),
                    g = c.createGain();
                g.gain.value = v;
                s.buffer = b;
                s.connect(g).connect(c.destination);
                s.start();
            } catch (e) {} }
        const sfx = { shoot() { burst(.09, .3);
                blip(430, 70, .09, .14); }, hit() { blip(210, 60, .12, .2, 'sawtooth'); },
            boom() { burst(.3, .3);
                blip(120, 28, .3, .2); }, hurt() { blip(140, 45, .25, .24, 'sawtooth'); },
            pick() { blip(660, 1320, .12, .14, 'sine'); } };

        function update(dt, now) {
            const run = keys.ShiftLeft || keys.ShiftRight,
                sp = (run ? 4 : 2.6) * dt,
                rot = 2.4 * dt;
            let mv = 0,
                st = 0;
            if (keys.KeyW || keys.ArrowUp) mv += 1;
            if (keys.KeyS || keys.ArrowDown) mv -= 1;
            if (keys.KeyA) st -= 1;
            if (keys.KeyD) st += 1;
            if (keys.ArrowLeft) p.a -= rot;
            if (keys.ArrowRight) p.a += rot;
            if (mv || st) { walkC += dt * 10;
                const dX = Math.cos(p.a),
                    dY = Math.sin(p.a),
                    nx = p.x + (dX * mv + -dY * st) * sp,
                    ny = p.y + (dY * mv + dX * st) * sp;
                if (!blocked(nx, p.y)) p.x = nx;
                if (!blocked(p.x, ny)) p.y = ny; }
            if (keys.Space) shoot(now);
            enemies.forEach(e => {
                if (e.dead) { e.deathT += dt; return; }
                if (e.pain > 0) e.pain -= dt;
                const dx = p.x - e.x,
                    dy = p.y - e.y,
                    d = Math.hypot(dx, dy);
                if (d < 7 && d > .6 && e.pain <= 0 && los(e.x, e.y, p.x, p.y)) {
                    const s = 1.05 * dt,
                        nx = e.x + dx / d * s,
                        ny = e.y + dy / d * s;
                    if (!blocked(nx, e.y)) e.x = nx;
                    if (!blocked(e.x, ny)) e.y = ny;
                }
                if (d < .8 && now - e.last > 850) { e.last = now;
                    p.hp -= 7 + Math.random() * 6 | 0;
                    dmgT = .5;
                    sfx.hurt(); if (p.hp <= 0) { p.hp = 0;
                        state = 'dead'; } }
            });
            pickups = pickups.filter(k => {
                if (Math.hypot(p.x - k.x, p.y - k.y) < .5) {
                    if (k.t === 'hp') { p.hp = Math.min(100, p.hp + 25);
                        msg = '+25 HP'; } else { p.ammo += 12;
                        msg = '+12 MUNITION'; }
                    msgT = 1.6;
                    p.score += 25;
                    sfx.pick();
                    return false;
                }
                return true;
            });
            flashT = Math.max(0, flashT - dt);
            dmgT = Math.max(0, dmgT - dt * 1.4);
            msgT = Math.max(0, msgT - dt);
            recoil = Math.max(0, recoil - dt * 5);
        }

        function shoot(now) {
            if (now - lastShot < 300 || state !== 'play') return;
            if (p.ammo <= 0) { msg = 'KEINE MUNITION';
                msgT = 1;
                lastShot = now; return; }
            p.ammo--;
            lastShot = now;
            flashT = .07;
            recoil = 1;
            sfx.shoot();
            const wd = rayDist(p.a);
            let best = null,
                bd = 1e9;
            enemies.forEach(e => {
                if (e.dead) return;
                const c = cam(e.x, e.y);
                if (c.ty > .3 && Math.abs(c.tx / c.ty) < .24 && c.ty < wd && c.ty < bd) { best = e;
                    bd = c.ty; }
            });
            if (best) { best.hp--;
                best.pain = .3;
                sfx.hit(); if (best.hp <= 0) { best.dead = true;
                    best.deathT = 0;
                    p.score += 100;
                    sfx.boom(); if (enemies.every(e => e.dead)) { state = 'won'; } } }
        }

        function render() {
            ctx.fillStyle = '#030303';
            ctx.fillRect(0, 0, W, H / 2);
            ctx.fillStyle = '#0b0b0b';
            ctx.fillRect(0, W ? H / 2 : 0, W, H / 2);
            ctx.fillStyle = 'rgba(214,0,28,.35)';
            ctx.fillRect(0, H / 2 - 1, W, 1);
            const dX = Math.cos(p.a),
                dY = Math.sin(p.a),
                plX = -dY * FOV,
                plY = dX * FOV;
            for (let x = 0; x < W; x++) {
                const camX = 2 * x / W - 1,
                    rdX = dX + plX * camX,
                    rdY = dY + plY * camX;
                let mX = p.x | 0,
                    mY = p.y | 0;
                const dDX = Math.abs(1 / (rdX || 1e-9)),
                    dDY = Math.abs(1 / (rdY || 1e-9));
                let stX, stY, sdX, sdY;
                if (rdX < 0) { stX = -1;
                    sdX = (p.x - mX) * dDX; } else { stX = 1;
                    sdX = (mX + 1 - p.x) * dDX; }
                if (rdY < 0) { stY = -1;
                    sdY = (p.y - mY) * dDY; } else { stY = 1;
                    sdY = (mY + 1 - p.y) * dDY; }
                let side = 0,
                    tile = '#';
                for (let i = 0; i < 64; i++) {
                    if (sdX < sdY) { sdX += dDX;
                        mX += stX;
                        side = 0; } else { sdY += dDY;
                        mY += stY;
                        side = 1; }
                    tile = cell(mX, mY);
                    if (tile === '#' || tile === '=') break;
                }
                const perp = side === 0 ? sdX - dDX : sdY - dDY;
                zbuf[x] = perp;
                let wallY = side === 0 ? p.y + perp * rdY : p.x + perp * rdX;
                wallY -= Math.floor(wallY);
                let txX = wallY * 64 | 0;
                if ((side === 0 && rdX > 0) || (side === 1 && rdY < 0)) txX = 63 - txX;
                const h = Math.min(H * 3, H / perp),
                    y0 = (H - h) / 2;
                ctx.drawImage(tile === '=' ? tex.panel : tex.wall, txX, 0, 1, 64, x, y0, 1, h);
                if (side === 1) { ctx.fillStyle = 'rgba(0,0,0,.4)';
                    ctx.fillRect(x, y0, 1, h); }
                const fog = Math.min(.82, perp / 11);
                if (fog > .02) { ctx.fillStyle = `rgba(0,0,0,${fog})`;
                    ctx.fillRect(x, y0, 1, h); }
            }
            const list = [];
            enemies.forEach(e => list.push({ x: e.x, y: e.y, e }));
            pickups.forEach(k => list.push({ x: k.x, y: k.y, k }));
            list.forEach(s => s.d = (s.x - p.x) ** 2 + (s.y - p.y) ** 2);
            list.sort((a, b) => b.d - a.d);
            list.forEach(s => {
                const c = cam(s.x, s.y);
                if (c.ty <= .25) return;
                const sx = (W / 2) * (1 + c.tx / c.ty);
                let img, sc = .92,
                    off = 0,
                    alpha = 1;
                if (s.k) { img = s.k.t === 'hp' ? sprHp : sprAmmo;
                    sc = .34;
                    off = .33; } else { const e = s.e; if (e.dead) { if (e.deathT > .5) return;
                        alpha = 1 - e.deathT / .5;
                        sc = .9 - e.deathT * 1.2;
                        img = sprImp; } else img = e.pain > 0 ? sprHurt : sprImp; }
                const size = H / c.ty,
                    hgt = size * sc,
                    wdt = size * sc,
                    y0 = H / 2 - hgt / 2 + size * off;
                ctx.globalAlpha = alpha;
                const x0 = sx - wdt / 2;
                for (let i = 0; i < wdt; i++) { const cx = Math.floor(x0 + i); if (cx < 0 || cx >= W || zbuf[cx] <= c.ty) continue;
                    ctx.drawImage(img, i / wdt * 64 | 0, 0, 1, 64, cx, y0, 1, hgt); }
                ctx.globalAlpha = 1;
            });
            const bob = Math.sin(walkC) * 2.5,
                wx = W / 2 + bob,
                wy = H - 26 + recoil * 5;
            ctx.fillStyle = '#0c0c0c';
            ctx.beginPath();
            ctx.moveTo(wx - 15, wy);
            ctx.lineTo(wx - 6, wy - 24);
            ctx.lineTo(wx + 6, wy - 24);
            ctx.lineTo(wx + 15, wy);
            ctx.fill();
            ctx.fillStyle = '#1c1c1c';
            ctx.fillRect(wx - 7, wy - 22, 14, 5);
            ctx.fillStyle = '#D6001C';
            ctx.fillRect(wx - 1, wy - 26, 2, 4);
            if (flashT > 0) { const r = 10 + Math.random() * 8;
                const gg = ctx.createRadialGradient(wx, wy - 30, 0, wx, wy - 30, r);
                gg.addColorStop(0, 'rgba(255,255,255,.95)');
                gg.addColorStop(.4, 'rgba(214,0,28,.8)');
                gg.addColorStop(1, 'rgba(214,0,28,0)');
                ctx.fillStyle = gg;
                ctx.fillRect(wx - r, wy - 30 - r, r * 2, r * 2); }
            ctx.fillStyle = '#050505';
            ctx.fillRect(0, H - 26, W, 26);
            ctx.fillStyle = '#D6001C';
            ctx.fillRect(0, H - 27, W, 1);
            ctx.font = '8px "IBM Plex Mono",monospace';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#fff';
            ctx.textAlign = 'left';
            ctx.fillText('HP', 8, H - 17);
            ctx.fillStyle = '#222';
            ctx.fillRect(26, H - 20, 60, 6);
            ctx.fillStyle = p.hp > 30 ? '#D6001C' : '#fff';
            ctx.fillRect(26, H - 20, 60 * p.hp / 100, 6);
            ctx.fillStyle = '#fff';
            ctx.fillText('MUN ' + p.ammo, 96, H - 17);
            ctx.fillText('SCORE ' + String(p.score).padStart(5, '0'), 160, H - 17);
            ctx.fillStyle = '#666';
            ctx.textAlign = 'right';
            ctx.fillText('SECTOR 07', W - 8, H - 17);
            ctx.fillStyle = 'rgba(255,255,255,.9)';
            ctx.fillRect(W / 2 - 4, H / 2, 3, 1);
            ctx.fillRect(W / 2 + 2, H / 2, 3, 1);
            ctx.fillRect(W / 2, H / 2 - 4, 1, 3);
            ctx.fillRect(W / 2, H / 2 + 2, 1, 3);
            ctx.fillStyle = 'rgba(0,0,0,.55)';
            ctx.fillRect(4, 4, RAW[0].length * 3 + 4, RAW.length * 3 + 4);
            RAW.forEach((row, y) => [...row].forEach((ch, x) => { if (ch === '#' || ch === '=') { ctx.fillStyle = 'rgba(255,255,255,.35)';
                    ctx.fillRect(6 + x * 3, 6 + y * 3, 3, 3); } }));
            ctx.fillStyle = '#D6001C';
            ctx.fillRect(5 + p.x * 3, 5 + p.y * 3, 2, 2);
            enemies.forEach(e => { if (!e.dead) { ctx.fillStyle = 'rgba(214,0,28,.8)';
                    ctx.fillRect(5 + e.x * 3, 5 + e.y * 3, 2, 2); } });
            if (dmgT > 0) { ctx.fillStyle = `rgba(214,0,28,${dmgT*.4})`;
                ctx.fillRect(0, 0, W, H); }
            if (msgT > 0) { ctx.fillStyle = '#fff';
                ctx.textAlign = 'center';
                ctx.font = '9px "IBM Plex Mono",monospace';
                ctx.fillText(msg, W / 2, 26); }
            if (state === 'dead' || state === 'won') {
                ctx.fillStyle = 'rgba(0,0,0,.72)';
                ctx.fillRect(0, 0, W, H);
                ctx.textAlign = 'center';
                ctx.fillStyle = state === 'won' ? '#fff' : '#D6001C';
                ctx.font = 'bold 20px "IBM Plex Mono",monospace';
                ctx.fillText(state === 'won' ? 'SECTOR GESÄUBERT' : 'SIGNAL VERLOREN', W / 2, H / 2 - 14);
                ctx.fillStyle = '#fff';
                ctx.font = '9px "IBM Plex Mono",monospace';
                ctx.fillText('SCORE ' + p.score, W / 2, H / 2 + 8);
                ctx.fillStyle = '#888';
                ctx.fillText('ENTER — NEUSTART      ESC — VERLASSEN', W / 2, H / 2 + 26);
            }
        }

        function loop(t) {
            if (!open) return;
            raf = requestAnimationFrame(loop);
            const now = performance.now(),
                dt = Math.min(.05, (t - last) / 1000);
            last = t;
            if (state === 'play') update(dt, now);
            if (state !== 'boot') render();
        }

        const BOOT = [
            'NOIRWERK RETRO SHELL v2.49',
            'COPYRIGHT (C) 2049 NW SYSTEMS', '',
            'MEMORY CHECK ......... 64K OK',
            'DISPLAY .............. 320x200',
            'SECTOR_07.RAW ........ GELADEN', '',
            '<span class="r">WARNUNG: FEINDLICHE EINHEITEN AKTIV</span>', '',
            'WAFFE .............. PULSE-9  [BEREIT]',
            'ZIEL ............... 8 EINHEITEN', '',
            '> START SIMULATION _'
        ];

        function boot() {
            const box = qs('#doomBoot'),
                pre = qs('#doomBootTxt');
            box.classList.add('show');
            pre.innerHTML = '';
            let li = 0,
                ci = 0,
                cur = '';
            const iv = setInterval(() => {
                if (li >= BOOT.length) { clearInterval(iv);
                    setTimeout(startPlay, reduced ? 100 : 900); return; }
                const line = BOOT[li];
                if (ci < line.length) {
                    if (line[ci] === '<') { const end = line.indexOf('>', ci);
                        cur += line.slice(ci, end + 1);
                        ci = end + 1; } else { cur += line[ci++]; }
                    pre.innerHTML = cur;
                } else { cur += '\n';
                    li++;
                    ci = 0; }
            }, reduced ? 2 : 14);
        }

        function startPlay() {
            qs('#doomBoot').classList.remove('show');
            const shell = qs('#doomShell');
            shell.classList.add('crt-on');
            setTimeout(() => shell.classList.remove('crt-on'), 600);
            state = 'play';
            msg = 'FINDE UND ELIMINIERE ALLE EINHEITEN';
            msgT = 3;
        }

        function openGame() {
            if (open) return;
            open = true;
            buildAssets();
            reset();
            state = 'boot';
            qs('#doom').classList.add('open');
            qs('#doom').setAttribute('aria-hidden', 'false');
            document.body.classList.add('doom-open');
            document.body.style.overflow = 'hidden';
            if (lenis) lenis.stop();
            try { ac().resume && ac().resume(); } catch (e) {}
            last = performance.now();
            raf = requestAnimationFrame(loop);
            boot();
            qs('#doomCanvas').focus();
        }

        function closeGame() {
            open = false;
            cancelAnimationFrame(raf);
            if (document.exitPointerLock) document.exitPointerLock();
            qs('#doom').classList.remove('open');
            qs('#doom').setAttribute('aria-hidden', 'true');
            document.body.classList.remove('doom-open');
            document.body.style.overflow = '';
            if (lenis) lenis.start();
            keys = {};
        }

        document.addEventListener('DOMContentLoaded', () => {
            const cv = qs('#doomCanvas');
            if (cv) {
                ctx = cv.getContext('2d');
                ctx.imageSmoothingEnabled = false;
                cv.addEventListener('click', () => {
                    if (state !== 'play') return;
                    if (document.pointerLockElement !== cv) cv.requestPointerLock && cv.requestPointerLock();
                    shoot(performance.now());
                });
                cv.addEventListener('mousedown', () => {
                    if (state === 'play' && document.pointerLockElement === cv) shoot(performance.now());
                });
            }
        });

        document.addEventListener('mousemove', e => {
            if (open && document.pointerLockElement === qs('#doomCanvas')) {
                p.a += e.movementX * .0026;
            }
        });

        let DoomBuf = '';

        document.addEventListener('keydown', e => {
            if (!open) {
                if (e.metaKey || e.ctrlKey || e.altKey) return;
                const t = e.target;
                if (t && (t.tagName === 'INPUT' || t.tagName === 'TEXTAREA' || t.tagName === 'SELECT' || t.isContentEditable)) return;
                DoomBuf = (DoomBuf + (e.key || '').toUpperCase()).slice(-4);
                if (DoomBuf === 'DOOM') openGame();
                return;
            }
            if (e.key === 'Escape') { closeGame(); return; }
            if ((state === 'dead' || state === 'won') && e.key === 'Enter') { reset();
                state = 'play'; return; }
            if (['Space', 'ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(e.code)) e.preventDefault();
            keys[e.code] = true;
        });

        document.addEventListener('keyup', e => { keys[e.code] = false; });
        document.addEventListener('visibilitychange', () => { if (document.hidden) keys = {}; });

        return { open: openGame, close: closeGame };
    })();

    window.Doom = Doom;

    const qs = (s, c = document) => c.querySelector(s);
    const qsa = (s, c = document) => [...c.querySelectorAll(s)];
    const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
    const fine = matchMedia('(pointer:fine)').matches;
    
    if (reduced) document.documentElement.classList.add('reduced');
    
    const hasLib = window.gsap && window.ScrollTrigger;
    if (hasLib) gsap.registerPlugin(ScrollTrigger);
    
    /* ---------- SMOOTH SCROLL ---------- */
    let lenis = null;
    if (hasLib && !reduced && window.Lenis) {
        lenis = new Lenis({
            lerp: .09,
            wheelMultiplier: 1,
            touchMultiplier: 1.6
        });
        lenis.on('scroll', ScrollTrigger.update);
        gsap.ticker.add(t => lenis.raf(t * 1000));
        gsap.ticker.lagSmoothing(0);
        window.lenis = lenis; // Für globale Nutzung
    }
    
    const scrollTo = (sel) => {
        const el = qs(sel);
        if (!el) return;
        if (lenis) {
            lenis.scrollTo(el, { offset: sel === '#home' ? 0 : -40 });
        } else {
            el.scrollIntoView({ behavior: reduced ? 'auto' : 'smooth' });
        }
    };
    
    // Smooth Scroll für alle internen Links
    qsa('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const h = a.getAttribute('href');
            if (h.length > 1 && h !== '#') {
                e.preventDefault();
                scrollTo(h);
                document.body.classList.remove('menu-open');
                const menuBtn = qs('#menuBtn');
                if (menuBtn) menuBtn.setAttribute('aria-expanded', 'false');
            }
        });
    });
    
    /* ---------- HEADER / MENU ---------- */
    const header = qs('#header');
    const menuBtn = qs('#menuBtn');
    
    window.addEventListener('scroll', () => {
        if (header) header.classList.toggle('is-solid', window.scrollY > 50);
    }, { passive: true });
    
    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            const o = document.body.classList.toggle('menu-open');
            menuBtn.setAttribute('aria-expanded', o);
        });
    }
    
    window.addEventListener('keydown', e => {
        if (e.key === 'Escape' && document.body.classList.contains('menu-open')) {
            document.body.classList.remove('menu-open');
            if (menuBtn) menuBtn.setAttribute('aria-expanded', 'false');
        }
    });
    
    /* ---------- BACK TO TOP ---------- */
    const backTop = qs('#backTop');
    let backTopVisible = false;
    
    window.addEventListener('scroll', () => {
        const show = window.scrollY > window.innerHeight * 0.7;
        if (show !== backTopVisible) {
            backTopVisible = show;
            if (backTop) backTop.classList.toggle('visible', show);
        }
    }, { passive: true });
    
    if (backTop) {
        backTop.addEventListener('click', function(e) {
            e.preventDefault();
            if (lenis) {
                lenis.scrollTo(0, { duration: 1.2 });
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    }
    
    /* ---------- PROJECT OVERLAY ---------- */
    const overlay = qs('#projectOverlay');
    const overlayClose = qs('#projectOverlayClose');
    
    function closeProject() {
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
        if (lenis) lenis.start();
    }
    
    if (overlayClose) {
        overlayClose.addEventListener('click', closeProject);
    }
    
    if (overlay) {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) closeProject();
        });
    }
    
    window.addEventListener('keydown', e => {
        if (e.key === 'Escape' && overlay && overlay.classList.contains('open')) {
            closeProject();
        }
    });
    
    // Project panels
    qsa('[data-project-open]').forEach(el => {
        el.addEventListener('click', e => {
            e.stopPropagation();
            const panel = el.closest('.panel');
            if (!panel) return;
            try {
                const data = JSON.parse(panel.dataset.project);
                if (overlay) {
                    const num = qs('#projectOverlayNum');
                    const title = qs('#projectOverlayTitle');
                    const year = qs('#projectOverlayYear');
                    const category = qs('#projectOverlayCategory');
                    const desc = qs('#projectOverlayDesc');
                    const tags = qs('#projectOverlayTags');
                    
                    if (num) num.textContent = data.num;
                    if (title) title.textContent = data.title;
                    if (year) year.textContent = data.year;
                    if (category) category.textContent = data.category;
                    if (desc) desc.textContent = data.desc;
                    if (tags) tags.innerHTML = data.tags.map(t => `<span>${t}</span>`).join('');
                    
                    overlay.classList.add('open');
                    document.body.style.overflow = 'hidden';
                    if (lenis) lenis.stop();
                }
            } catch(err) {}
        });
    });
    
    /* ---------- CURSOR + GLOW ---------- */
    if (fine) {
        const dot = qs('#curDot');
        const ring = qs('#curRing');
        const label = qs('#curLabel');
        const glow = qs('#glow');
        let mx = window.innerWidth / 2, my = window.innerHeight / 2;
        let rx = mx, ry = my, gx = mx, gy = my;
        
        document.addEventListener('mousemove', e => {
            mx = e.clientX;
            my = e.clientY;
            if (dot) dot.style.transform = `translate(${mx}px, ${my}px) translate(-50%, -50%)`;
        });
        
        const animateCursor = () => {
            rx += (mx - rx) * .16;
            ry += (my - ry) * .16;
            gx += (mx - gx) * .06;
            gy += (my - gy) * .06;
            
            if (ring) {
                ring.style.transform = `translate(${rx}px, ${ry}px) translate(-50%, -50%)`;
            }
            if (label) {
                label.style.left = label.style.top = '0';
                const scale = label.dataset.on === '1' ? 1 : 0;
                label.style.transform = `translate(${rx}px, ${ry}px) translate(-50%, -50%) scale(${scale})`;
            }
            if (glow) {
                glow.style.transform = `translate(${gx - 260}px, ${gy - 260}px)`;
            }
            requestAnimationFrame(animateCursor);
        };
        animateCursor();
        
        document.addEventListener('mouseover', e => {
            const c = e.target.closest('[data-cursor]');
            const l = e.target.closest('a, button, .faq__btn, .panel');
            
            if (c && label) {
                label.textContent = c.dataset.cursor;
                label.dataset.on = '1';
                document.body.classList.add('cur-label-on');
            } else if (label) {
                label.dataset.on = '0';
                document.body.classList.remove('cur-label-on');
            }
            
            document.body.classList.toggle('cur-link', !!(l && !c));
            document.body.classList.toggle('cur-hover', !!e.target.closest('.srv'));
        });
        
        // Magnetic buttons
        qsa('[data-magnetic]').forEach(el => {
            el.addEventListener('mousemove', e => {
                if (!hasLib) return;
                const r = el.getBoundingClientRect();
                gsap.to(el, {
                    x: (e.clientX - r.left - r.width / 2) * .28,
                    y: (e.clientY - r.top - r.height / 2) * .28,
                    duration: .6,
                    ease: 'power3.out'
                });
            });
            el.addEventListener('mouseleave', () => {
                if (!hasLib) return;
                gsap.to(el, { x: 0, y: 0, duration: .8, ease: 'elastic.out(1,.4)' });
            });
        });
        
        // Card glow
        qsa('.srv').forEach(card => {
            card.addEventListener('mousemove', e => {
                const r = card.getBoundingClientRect();
                card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                card.style.setProperty('--my', (e.clientY - r.top) + 'px');
            });
        });
    }
    
    /* ---------- CLOCK / PROGRESS ---------- */
    const clocks = [qs('#clockHero'), qs('#clockFoot')];
    const tickClock = () => {
        const s = new Date().toLocaleTimeString('de-DE', { hour12: false });
        clocks.forEach(c => c && (c.textContent = s));
    };
    tickClock();
    setInterval(tickClock, 1000);
    
    if (qs('#year')) qs('#year').textContent = new Date().getFullYear();
    
    if (hasLib && qs('#progress')) {
        gsap.to('#progress', {
            scaleX: 1,
            ease: 'none',
            scrollTrigger: { start: 0, end: 'max', scrub: .3 }
        });
    }
    
    /* ---------- REVEALS ---------- */
    if (hasLib && !reduced) {
        qsa('[data-reveal]').forEach(el => {
            gsap.from(el, {
                y: 44,
                autoAlpha: 0,
                duration: 1.1,
                ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 86%' }
            });
        });
        
        qsa('[data-reveal-img]').forEach(el => {
            gsap.from(el, {
                clipPath: 'inset(100% 0 0 0)',
                duration: 1.3,
                ease: 'power4.inOut',
                scrollTrigger: { trigger: el, start: 'top 82%' }
            });
            gsap.from(el.firstElementChild, {
                scale: 1.25,
                duration: 1.8,
                ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 82%' }
            });
        });
    }
    
    /* ---------- FAQ ---------- */
    qsa('.faq__item').forEach(item => {
        const btn = item.querySelector('.faq__btn');
        const panel = item.querySelector('.faq__panel');
        if (!btn || !panel) return;
        
        btn.addEventListener('click', () => {
            const open = item.classList.contains('open');
            
            qsa('.faq__item.open').forEach(o => {
                if (o !== item) {
                    o.classList.remove('open');
                    o.querySelector('.faq__btn').setAttribute('aria-expanded', 'false');
                    if (hasLib) {
                        gsap.to(o.querySelector('.faq__panel'), { height: 0, duration: .5, ease: 'power3.inOut' });
                    } else {
                        o.querySelector('.faq__panel').style.height = '0';
                    }
                }
            });
            
            item.classList.toggle('open', !open);
            btn.setAttribute('aria-expanded', String(!open));
            
            if (hasLib) {
                gsap.to(panel, {
                    height: open ? 0 : panel.scrollHeight + 'px',
                    duration: .6,
                    ease: 'power3.inOut'
                });
            } else {
                panel.style.height = open ? '0' : panel.scrollHeight + 'px';
            }
        });
    });
    
    /* ---------- HERO RAIN CANVAS ---------- */
    (function rain() {
        const cv = qs('#rain');
        if (!cv) return;
        const g = cv.getContext('2d');
        let w, h, dpr = 1, drops = [], bld = [], wins = [], nextFlash = 6000, lastFlash = -1e9, running = true, raf = 0, tPrev = 0;
        
        function resize() {
            dpr = Math.min(devicePixelRatio || 1, 1.5);
            w = cv.clientWidth;
            h = cv.clientHeight;
            cv.width = w * dpr;
            cv.height = h * dpr;
            g.setTransform(dpr, 0, 0, dpr, 0, 0);
            build();
        }
        
        function build() {
            bld = [];
            wins = [];
            let x = 0;
            while (x < w) {
                const bw = 40 + Math.random() * 130;
                const bh = h * (.16 + Math.random() * .36);
                bld.push({ x, w: bw, h: bh });
                for (let i = 0; i < bw * bh / 1100; i++) {
                    wins.push({
                        x: x + 3 + Math.random() * (bw - 6),
                        y: h - bh + 3 + Math.random() * (bh - 8),
                        r: Math.random() < .16,
                        p: Math.random() * 6.28
                    });
                }
                x += bw + (Math.random() < .3 ? 10 : 2);
            }
            drops = [];
            const n = Math.min(230, w / 5 | 0);
            for (let i = 0; i < n; i++) drops.push(newDrop(true));
        }
        
        function newDrop(any) {
            const z = .3 + Math.random() * .7;
            return {
                x: Math.random() * (w + 60),
                y: any ? Math.random() * h : -30,
                l: 9 + z * 24,
                s: 4.5 + z * 10,
                a: .05 + z * .11,
                d: -1.4 * z
            };
        }
        
        function tick(t) {
            if (!running) return;
            raf = requestAnimationFrame(tick);
            const dt = Math.min(34, t - tPrev) / 16.7;
            tPrev = t;
            
            const grd = g.createLinearGradient(0, 0, 0, h);
            grd.addColorStop(0, '#050505');
            grd.addColorStop(.55, '#020202');
            grd.addColorStop(1, '#000');
            g.fillStyle = grd;
            g.fillRect(0, 0, w, h);
            
            const gx = w * .72 + Math.sin(t * .00012) * w * .06;
            const gy = h * .6;
            const rg = g.createRadialGradient(gx, gy, 0, gx, gy, w * .5);
            rg.addColorStop(0, 'rgba(214,0,28,.11)');
            rg.addColorStop(1, 'rgba(214,0,28,0)');
            g.fillStyle = rg;
            g.fillRect(0, 0, w, h);
            
            if (t > nextFlash) {
                lastFlash = t;
                nextFlash = t + 6000 + Math.random() * 8000;
            }
            const fl = Math.max(0, 1 - (t - lastFlash) / 900);
            if (fl > 0) {
                g.fillStyle = `rgba(255,255,255,${(fl * .05).toFixed(3)})`;
                g.fillRect(0, 0, w, h);
            }
            
            g.fillStyle = '#000';
            for (const b of bld) g.fillRect(b.x, h - b.h, b.w, b.h);
            
            for (const p of wins) {
                const tw = .5 + .5 * Math.sin(t * .0012 + p.p);
                g.fillStyle = p.r ? `rgba(214,0,28,${.2 + .45 * tw})` : `rgba(255,255,255,${.05 + .2 * tw})`;
                g.fillRect(p.x, p.y, 2, 2);
            }
            
            g.lineWidth = 1;
            for (const d of drops) {
                d.y += d.s * dt;
                d.x += d.d * dt;
                if (d.y > h + 30) Object.assign(d, newDrop(false));
                g.strokeStyle = `rgba(255,255,255,${d.a})`;
                g.beginPath();
                g.moveTo(d.x, d.y);
                g.lineTo(d.x + d.d * 2.2, d.y - d.l);
                g.stroke();
            }
        }
        
        resize();
        window.addEventListener('resize', resize);
        
        new IntersectionObserver(([e]) => {
            const on = e.isIntersecting;
            if (on && !running) {
                running = true;
                tPrev = performance.now();
                raf = requestAnimationFrame(tick);
            } else if (!on && running) {
                running = false;
                cancelAnimationFrame(raf);
            }
        }).observe(cv);
        
        if (!reduced) {
            tPrev = performance.now();
            raf = requestAnimationFrame(tick);
        } else {
            tPrev = 0;
            running = true;
            raf = requestAnimationFrame(tick);
        }
    })();
    
    window.addEventListener('load', () => ScrollTrigger && ScrollTrigger.refresh());
    
    console.log('%c NOIRWERK® ', 'background:#D6001C;color:#000;font-weight:bold;padding:4px 8px;font-family:monospace');
    console.log('%cSECTOR 07 ACTIVE — tippe D·O·O·M, wenn du bereit bist.', 'color:#666;font-family:monospace');
    
})();

/* ================================================================
   KONTAKTFORMULAR - AJAX
================================================================ */

// document.addEventListener('DOMContentLoaded', function() {
//     const form = document.getElementById('contactForm');
//     if (!form) return;
    
//     form.addEventListener('submit', function(e) {
//         e.preventDefault();
        
//         const submitBtn = form.querySelector('button[type="submit"]');
//         const originalText = submitBtn.innerHTML;
//         submitBtn.innerHTML = 'Sende...';
//         submitBtn.disabled = true;
        
//         const formData = new FormData(form);
//         formData.append('action', 'noirwerk_contact');
//         formData.append('nonce', noirwerk_ajax.nonce);
        
//         fetch(noirwerk_ajax.ajax_url, {
//             method: 'POST',
//             body: formData
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 form.innerHTML = `
//                     <div class="contact-success">
//                         <h3>✅ Nachricht gesendet</h3>
//                         <p>${data.data.message}</p>
//                     </div>
//                 `;
//             } else {
//                 submitBtn.innerHTML = originalText;
//                 submitBtn.disabled = false;
//                 alert('Fehler: ' + data.data.message);
//             }
//         })
//         .catch(error => {
//             submitBtn.innerHTML = originalText;
//             submitBtn.disabled = false;
//             alert('Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.');
//         });
//     });
// });


