
      // Loader functionality
    //   window.addEventListener("load", function () {
    //     const loader = document.getElementById("loader");
    //     const body = document.body;

    //     // Hide loader after a minimum of 2 seconds or when page is fully loaded
    //     setTimeout(() => {
    //       loader.classList.add("fade-out");
    //       body.classList.remove("loading");

    //       // Remove loader from DOM after animation
    //       setTimeout(() => {
    //         loader.style.display = "none";
    //       }, 500);
    //     }, 2000);
    //   });

      // Smooth scrolling for navigation links
      document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute("href"));
          if (target) {
            target.scrollIntoView({
              behavior: "smooth",
              block: "start",
            });
          }
        });
      });

      // Add scroll effect to header
      window.addEventListener("scroll", function () {
        const header = document.querySelector("header");
        if (window.scrollY > 100) {
          header.style.background = "rgba(102, 126, 234, 0.95)";
          header.style.backdropFilter = "blur(10px)";
        } else {
          header.style.background =
            "linear-gradient(135deg, #667eea 0%, #764ba2 100%)";
          header.style.backdropFilter = "none";
        }
      });

      // Animate stats when they come into view
      const observerOptions = {
        threshold: 0.5,
        rootMargin: "0px 0px -100px 0px",
      };

      const observer = new IntersectionObserver(function (entries) {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll(".stat-item h3");
            counters.forEach((counter) => {
              const target = parseInt(counter.textContent);
              let current = 0;
              const increment = target / 50;
              const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                  counter.textContent =
                    target +
                    (counter.textContent.includes("k")
                      ? "k+"
                      : counter.textContent.includes("%")
                      ? "%"
                      : "");
                  clearInterval(timer);
                } else {
                  counter.textContent =
                    Math.floor(current) +
                    (counter.textContent.includes("k")
                      ? "k+"
                      : counter.textContent.includes("%")
                      ? "%"
                      : "");
                }
              }, 50);
            });
            observer.unobserve(entry.target);
          }
        });
      }, observerOptions);

      const statsSection = document.querySelector(".stats");
      if (statsSection) {
        observer.observe(statsSection);
      }
