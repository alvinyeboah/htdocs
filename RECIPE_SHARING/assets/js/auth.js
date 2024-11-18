const images = [
  "../assets/images/img1.jpg",
  "../assets/images/img2.jpg",
  "../assets/images/img3.jpg",
  "../assets/images/img4.jpg"
];

let currentImageIndex = 0;
const $imageElement = $("#imageSwitcher");

function switchImage() {
  currentImageIndex = (currentImageIndex + 1) % images.length;
  $imageElement.attr("src", images[currentImageIndex]);
}

setInterval(switchImage, 5000);

$(window).on("load", () => {
  $imageElement.css("opacity", 1);
});

const $loginTab = $("#loginTab");
const $signupTab = $("#signupTab");
const $loginPage = $(".login-page");
const $signupPage = $(".signup-page");

$loginTab.on("click", () => {
  $loginTab.addClass("active");
  $signupTab.removeClass("active");
  $loginPage.show();
  $signupPage.hide();
});

function loginActive() {
  $loginTab.addClass("active");
  $signupTab.removeClass("active");
  $loginPage.show();
  $signupPage.hide();
}

$signupTab.on("click", () => {
  $signupTab.addClass("active");
  $loginTab.removeClass("active");
  $signupPage.show();
  $loginPage.hide();
});