/**
* noirwerk.js - GSAP Stats Counter Animation (ScrollTrigger) 
*/console.log("noirwerk.js Loaded!");
(function () {
    // Statistiken mit der GSAP-ScrollTrigger-Animation:
    const counterElements = document.querySelectorAll(".counter");
    if (counterElements.length > 0) {        gsap.fromTo(counterElements,
            { opacity: 0, y: 60 },            {
                scrollTrigger: {
                    trigger: ".counter",
                    start: "top center-=15%", // wenn oben sichtbar (ScrollTrigger)
                    onEnter: () => { }
                }
        // GSAP-Animation für Statistik mit ScrollTrigger:
                gsap.fromTo('.counter',
                    { opacity: 0, y: 80 },                    {
                        scrollTrigger: {
                            trigger: ".counter",
                            toggleActions: "play none reset none"
                                                                    const counterEl = this;
                            let targetVal = +this.dataset.count;                            gsap.to(this, { count: targetVal });
                            // GSAP Counter Animation in der main.js:                            let counters = document.querySelectorAll(".counter");
                            for(let i = 0; i<counters.length; i++){            const counterEl = counters[i];            if(counterEl) {                gsap.to(counterEl, count: { value: +counterEl.getAttribute("data-count"), duration: 1.5 })
                // GSAP Counter mit ScrollTrigger in main.js:                gsap.from(".counter", {
                    scrollTrigger: ".counter",
                    trigger: "body",  // für den ganzen body / viewport
                    yPercent: -20,
                    opacity: 0
                })            }
        })();