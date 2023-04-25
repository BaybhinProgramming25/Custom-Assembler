const likeButtons = document.querySelectorAll('.like-btn.btn-success');
  likeButtons.forEach(button => button.removeEventListener('click', sendLikeToServer));
  likeButtons.forEach(button => button.addEventListener('click', sendLikeToServer));

  const dislikeButtons = document.querySelectorAll('.like-btn.btn-warning');
  dislikeButtons.forEach(button => button.removeEventListener('click', removeLikeFromServer));
  dislikeButtons.forEach(button => button.addEventListener('click', removeLikeFromServer));


function sendLikeToServer(e) {
  const { msg, usr } = e.target.dataset;
  const data = new FormData();
  data.append('from', usr);
  data.append('to', msg);

  fetch('/aux/like.php', {
    "method": "POST",
    "body": data
  })
  .then(res => res.json())
  .then(res => {
    if (res === 1) toggleLikeButton(msg, true);
  });
}

function removeLikeFromServer(e) {
  const { msg, usr } = e.target.dataset;
  const data = new FormData();
  data.append('from', usr);
  data.append('to', msg);

  fetch('/aux/unlike.php', {
    "method": "POST",
    "body": data
  })
  .then(res => res.json())
  .then(res => {
    if (res === 1) toggleLikeButton(msg, false);
  });
}

function restartButtonListener(button, direction) {
  if (!direction) {
    button.removeEventListener('click', removeLikeFromServer);
    button.addEventListener('click', sendLikeToServer);
  } else {
    button.removeEventListener('click', sendLikeToServer);
    button.addEventListener('click', removeLikeFromServer);
  }
};

function toggleLikeButton(id, operation) {
  const button = document.querySelector(`button[data-msg="${id}"]`);
  const span = document.querySelector(`span[data-msg="${id}"]`);

  // Change button style while the page isn't reloaded
  button.textContent = !operation ? "Like" : "Unlike";
  button.classList.toggle("btn-success");
  button.classList.toggle("btn-warning");

  // Add one to the likes number while the page isn't reloaded
  let original = +span.textContent;
  span.textContent = operation ? original += 1 : original -= 1;

  // Restart listeners to avoid refreshing the page to click the same button
  restartButtonListener(button, operation);
}
