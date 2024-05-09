// Initial References
// Get references to key elements in the DOM
const moves = document.getElementById("moves"); // The element displaying the number of moves
const container = document.querySelector(".container"); // The main game container
const startButton = document.getElementById("start-button"); // The start/restart button
const coverScreen = document.querySelector(".cover-screen"); // The initial screen covering the game
const result = document.getElementById("result"); // The element displaying the result
let currentElement = ""; // The currently selected element
let movesCount, // The count of moves made
  imagesArr = []; // The array holding the current state of the game

// Function to check if the current device is a touch device
const isTouchDevice = () => {
  try {
    // Try to create a TouchEvent (this would fail for desktops and throw an error)
    document.createEvent("TouchEvent");
    return true;
  } catch (e) {
    return false;
  }
};

// Function to generate a random number for the image
const randomNumber = () => Math.floor(Math.random() * 8) + 1;

// Function to get the row and column value from the data-position attribute
const getCoords = (element) => {
  const [row, col] = element.getAttribute("data-position").split("_");
  return [parseInt(row), parseInt(col)];
};

// Function to check if two cells are adjacent
// row1, col1 are the coordinates of the current image
// row2, col2 are the coordinates of the blank image
const checkAdjacent = (row1, row2, col1, col2) => {
  if (row1 == row2) {
    // Check if the cells are adjacent horizontally (left/right)
    if (col2 == col1 - 1 || col2 == col1 + 1) {
      return true;
    }
  } else if (col1 == col2) {
    // Check if the cells are adjacent vertically (up/down)
    if (row2 == row1 - 1 || row2 == row1 + 1) {
      return true;
    }
  }
  return false;
};

// Function to fill the array with random values for the images
const randomImages = () => {
  while (imagesArr.length < 8) {
    let randomVal = randomNumber();
    if (!imagesArr.includes(randomVal)) {
      imagesArr.push(randomVal);
    }
  }
  imagesArr.push(9); // Add the blank image (represented by 9) to the end of the array
};

// Function to generate the grid for the game
const gridGenerator = () => {
  let count = 0;
  for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 3; j++) {
      let div = document.createElement("div");
      div.setAttribute("data-position", `${i}_${j}`);
      div.addEventListener("click", selectImage);
      div.classList.add("image-container");
      div.innerHTML = `<img src="1.jpg${
        imagesArr[count]
      }.jpg" class="image ${
        imagesArr[count] == 9 ? "target" : ""
      }" data-index="${imagesArr[count]}"/>`;
      count += 1;
      container.appendChild(div);
    }
  }
};

// Function to handle the click event on an image
const selectImage = (e) => {
  e.preventDefault();
  // Set the currentElement to the clicked element
  currentElement = e.target;
  // Get the target (blank) image
  let targetElement = document.querySelector(".target");
  let currentParent = currentElement.parentElement;
  let targetParent = targetElement.parentElement;

  // Get the row and column values for both elements
  const [row1, col1] = getCoords(currentParent);
  const [row2, col2] = getCoords(targetParent);

  if (checkAdjacent(row1, row2, col1, col2)) {
    // If the clicked image is adjacent to the blank image, swap them
    currentElement.remove();
    targetElement.remove();
    // Get the image index (to be used later for manipulating the array)
    let currentIndex = parseInt(currentElement.getAttribute("data-index"));
    let targetIndex = parseInt(targetElement.getAttribute("data-index"));
    // Swap the index
    currentElement.setAttribute("data-index", targetIndex);
    targetElement.setAttribute("data-index", currentIndex);
    // Swap the images
    currentParent.appendChild(targetElement);
    targetParent.appendChild(currentElement);
    // Swap the corresponding elements in the array
    let currentArrIndex = imagesArr.indexOf(currentIndex);
    let targetArrIndex = imagesArr.indexOf(targetIndex);
    [imagesArr[currentArrIndex], imagesArr[targetArrIndex]] = [
      imagesArr[targetArrIndex],
      imagesArr[currentArrIndex],
    ];

    // Check the win condition (if the array is in the correct order)
    if (imagesArr.join("") == "123456789") {
      setTimeout(() => {
        // When the game ends, display the cover screen again
        coverScreen.classList.remove("hide");
        container.classList.add("hide");
        result.innerText = `Total Moves: ${movesCount}`;
        startButton.innerText = "RestartGame";
      }, 1000);
    }
    // Increment and display the move count
    movesCount += 1;
    moves.innerText = `Moves: ${movesCount}`;
  }
};

// The click event on the start button should display the game container
startButton.addEventListener("click", () => {
  container.classList.remove("hide");
  coverScreen.classList.add("hide");
  container.innerHTML = "";
  imagesArr = [];
  randomImages();
  gridGenerator();
  movesCount = 0;
  moves.innerText = `Moves: ${movesCount}`;
});

// Display the start screen first
window.onload = () => {
  coverScreen.classList.remove("hide");
  container.classList.add("hide");
};
