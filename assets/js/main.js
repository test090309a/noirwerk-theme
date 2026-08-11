/* ================================================================
   NOIRWERK — main.js
================================================================ */

(() => {
    'use strict';
    
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