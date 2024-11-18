gsap.registerPlugin(ScrollTrigger);

const navbar = document.getElementById("main-nav");
let lastScrollTop = 0;

window.addEventListener("scroll", () => {
  let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  if (scrollTop > lastScrollTop) {
    navbar.style.transform = "translateY(-100%)";
  } else {
    navbar.style.transform = "translateY(0)";
  }
  lastScrollTop = scrollTop;
});

const menuToggle = document.getElementById("menu-toggle");
const mobileMenu = document.createElement("div");
mobileMenu.classList.add("mobile-menu");
document.body.appendChild(mobileMenu);

menuToggle.addEventListener("click", () => {
  mobileMenu.classList.toggle("active");
  document.body.classList.toggle("menu-open");
});

const navLinks = document.querySelectorAll(".nav-links a");
navLinks.forEach((link) => {
  const mobileLink = link.cloneNode(true);
  mobileMenu.appendChild(mobileLink);
});

document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    mobileMenu.classList.remove("active");
    document.body.classList.remove("menu-open");

    const target = document.querySelector(this.getAttribute("href"));
    target.scrollIntoView({
      behavior: "smooth",
      block: "start",
    });
  });
});

gsap.from(".hero-content", {
  opacity: 0,
  y: 50,
  duration: 1,
  ease: "power3.out",
});

gsap.from(".recipe-card", {
  opacity: 0,
  y: 50,
  stagger: 0.2,
  duration: 0.8,
  ease: "power3.out",
  scrollTrigger: {
    trigger: "#featured",
    start: "top 80%",
  },
});

gsap.from(".category-item", {
  opacity: 0,
  y: 50,
  stagger: 0.2,
  duration: 0.8,
  ease: "power3.out",
  scrollTrigger: {
    trigger: "#categories",
    start: "top 80%",
  },
});

gsap.from(".community-content", {
  opacity: 0,
  y: 50,
  duration: 0.8,
  ease: "power3.out",
  scrollTrigger: {
    trigger: "#community",
    start: "top 80%",
  },
});

const categoryItems = document.querySelectorAll(".category-item");
categoryItems.forEach((item) => {
  const image = item.querySelector(".category-image");
  gsap.to(image, {
    y: "20%",
    ease: "none",
    scrollTrigger: {
      trigger: item,
      start: "top bottom",
      end: "bottom top",
      scrub: true,
    },
  });
});

const cursor = document.createElement("div");
cursor.classList.add("cursor-trail");
document.body.appendChild(cursor);

let mouseX = 0;
let mouseY = 0;

document.addEventListener("mousemove", (e) => {
  mouseX = e.clientX;
  mouseY = e.clientY;
});

gsap.ticker.add(() => {
  gsap.to(cursor, {
    duration: 0.3,
    x: mouseX,
    y: mouseY,
  });
});

class TextScramble {
  constructor(el) {
    this.el = el;
    this.chars = "!<>-_\\/[]{}—=+*^?#________";
    this.update = this.update.bind(this);
  }
  setText(newText) {
    const oldText = this.el.innerText;
    const length = Math.max(oldText.length, newText.length);
    const promise = new Promise((resolve) => (this.resolve = resolve));
    this.queue = [];
    for (let i = 0; i < length; i++) {
      const from = oldText[i] || "";
      const to = newText[i] || "";
      const start = Math.floor(Math.random() * 40);
      const end = start + Math.floor(Math.random() * 40);
      this.queue.push({ from, to, start, end });
    }
    cancelAnimationFrame(this.frameRequest);
    this.frame = 0;
    this.update();
    return promise;
  }
  update() {
    let output = "";
    let complete = 0;
    for (let i = 0, n = this.queue.length; i < n; i++) {
      let { from, to, start, end, char } = this.queue[i];
      if (this.frame >= end) {
        complete++;
        output += to;
      } else if (this.frame >= start) {
        if (!char || Math.random() < 0.28) {
          char = this.randomChar();
          this.queue[i].char = char;
        }
        output += `<span class="dud">${char}</span>`;
      } else {
        output += from;
      }
    }
    this.el.innerHTML = output;
    if (complete === this.queue.length) {
      this.resolve();
    } else {
      this.frameRequest = requestAnimationFrame(this.update);
      this.frame++;
    }
  }
  randomChar() {
    return this.chars[Math.floor(Math.random() * this.chars.length)];
  }
}

document.querySelectorAll("h2").forEach((heading) => {
  const fx = new TextScramble(heading);
  fx.setText(heading.textContent);

  ScrollTrigger.create({
    trigger: heading,
    start: "top 80%",
    onEnter: () => fx.setText(heading.textContent),
  });
});
const recipeCardContainer = document.getElementById("recipe-card-container");
const scrollContainer = document.getElementById("recipe-scroll-container");
let isScrolling = true;
let scrollInterval;


const recipes = [
  {
    title: "Spaghetti Carbonara",
    description: "Classic Italian pasta dish",
    image: "../assets/images/test3.jpg",
  },
  {
    title: "Chicken Stir Fry",
    description: "Quick and healthy meal",
    image: "../assets/images/test4.jpg",

  },
  {
    title: "Vegetable Curry",
    description: "Spicy and flavorful curry",
    image: "../assets/images/food1.jpeg",

  },
  {
    title: "Grilled Salmon",
    description: "Omega-3 rich seafood",
    image: "../assets/images/test1.jpg",

  },
  {
    title: "Caesar Salad",
    description: "Classic romaine lettuce salad",
    image: "../assets/images/food2.jpeg",

  },
  // Add more recipes as needed
];

function createRecipeCard(recipe) {
  const card = document.createElement("div");
  card.className = "recipe-card";
  card.innerHTML = `
        <img src="${recipe.image}" alt="${recipe.title}" class="recipe-card__image">
        <div class="recipe-card__content">
            <h2 class="recipe-card__title">${recipe.title}</h2>
            <p class="recipe-card__description">${recipe.description}</p>
        </div>
    `;
  card.addEventListener("click", toggleScrolling);
  return card;
}

function loadRecipes() {
  recipes.forEach((recipe) => {
    const card = createRecipeCard(recipe);
    recipeCardContainer.appendChild(card);
  });
}

function cloneRecipes() {
  const cards = recipeCardContainer.querySelectorAll(".recipe-card");
  cards.forEach((card) => {
    const clone = card.cloneNode(true);
    clone.addEventListener("click", toggleScrolling);
    recipeCardContainer.appendChild(clone);
  });
}

function startScrolling() {
  scrollInterval = setInterval(() => {
    scrollContainer.scrollLeft += 1;
    if (
      scrollContainer.scrollLeft >=
      recipeCardContainer.scrollWidth - scrollContainer.offsetWidth
    ) {
      scrollContainer.scrollLeft = 0;
    }
  }, 20);
}

function stopScrolling() {
  clearInterval(scrollInterval);
}

function toggleScrolling() {
  if (isScrolling) {
    stopScrolling();
  } else {
    startScrolling();
  }
  isScrolling = !isScrolling;
}

// Initial load
loadRecipes();
cloneRecipes(); // Clone recipes to create an infinite loop
startScrolling();

// Infinite scroll effect
scrollContainer.addEventListener("scroll", () => {
  if (
    scrollContainer.scrollLeft >=
    (recipeCardContainer.scrollWidth - scrollContainer.offsetWidth) / 2
  ) {
    cloneRecipes();
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

  tl.from(".featured-recipe__title", { opacity: 0, y: 50, duration: 1 })
    .from(
      ".featured-recipe__description",
      { opacity: 0, y: 30, duration: 1 },
      "-=0.5"
    )
    .from(
      ".featured-recipe__details li",
      { opacity: 0, x: -30, stagger: 0.2, duration: 0.8 },
      "-=0.5"
    )
    .from(
      ".featured-recipe__button",
      { opacity: 0, y: 30, duration: 0.8 },
      "-=0.5"
    )
    .from(
      ".featured-recipe__image",
      { opacity: 0, scale: 1.2, duration: 1.5 },
      "-=1"
    );

  // Parallax effect on image
  gsap.to(".featured-recipe__image", {
    yPercent: -20,
    ease: "none",
    scrollTrigger: {
      trigger: ".featured-recipe",
      scrub: true,
    },
  });
});
