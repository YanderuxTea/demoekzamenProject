document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("imageContainer");
  const childrens = container.children;
  let currentIndex = 1;
  let intervalId;
  function updateSlider() {
    for (let child of childrens) {
      const index = child.dataset.index;
      if (Number(index) !== (Math.abs(currentIndex - 1) % 4) + 1) {
        child.classList.add("inactive");
        child.classList.remove("active");
      } else {
        child.classList.add("active");
        child.classList.remove("inactive");
      }
    }
  }
  function setIntervalFunction() {
    intervalId = setInterval(() => {
      currentIndex++;
      updateSlider();
    }, 3000);
  }

  function prevButtonHandler() {
    clearInterval(intervalId);
    currentIndex--;
    updateSlider();
    setIntervalFunction();
  }
  function nextButtonHandler() {
    clearInterval(intervalId);
    currentIndex++;
    updateSlider();
    setIntervalFunction();
  }
  const prevButton = document.getElementById("prevButton");
  const nextButton = document.getElementById("nextButton");
  prevButton.addEventListener("click", prevButtonHandler);
  nextButton.addEventListener("click", nextButtonHandler);
  updateSlider();
  setIntervalFunction();
});
