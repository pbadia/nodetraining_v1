/* This script allows the addition or removal of answers
for a specific question */

document.addEventListener("DOMContentLoaded", function() {
    /* DELETE BUTTON SECTION */

    // Get the div that holds the collection of answers
    let collectionHolder = document.querySelector(".js-answers-wrapper");

    // Add a delete button to all of the existing answer elements
    collectionHolder.querySelectorAll(".js-answer").forEach(function(element) {

        addDeleteLink(element);
    });

    /* ADD ANSWER SECTION */

    // Get the current answers count
    const index = collectionHolder.querySelectorAll("input").length;
    collectionHolder.setAttribute('index', index.toString());

    // New answer button setup
    const addAnswerButton = document.createElement("button");
    addAnswerButton.id = "js-answer-add";
    addAnswerButton.innerHTML = "Ajouter une réponse";
    addAnswerButton.className = "btn btn-secondary js-answer-add";
    const newAnswerDiv = document.createElement("div");
    newAnswerDiv.append(addAnswerButton);

    // Add the "add an answer" anchor
    collectionHolder.append(newAnswerDiv);

    addAnswerButton.addEventListener("click", function () {
        // Add a new answer form (see next code block)
        addAnswerForm(collectionHolder, newAnswerDiv);

    });
});

function addAnswerForm(collectionHolder, newAnswerDiv) {

    // Get the data-prototype
    const prototype = collectionHolder.getAttribute('data-prototype');

    // Get the new index
    const index = collectionHolder.getAttribute('index');
    let newForm = prototype;

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);
    // Increase the index with one for the next item
    collectionHolder.setAttribute('index', index + 1);

    // Display the form in the page in a div, before the "Add a answer" button
    const newFormDiv = document.createElement("div");
    newFormDiv.className = "row mb-2";
    newFormDiv.insertAdjacentHTML('afterbegin', newForm);
    addDeleteLink(newFormDiv);
    newAnswerDiv.before(newFormDiv);
}

function addDeleteLink(div) {
    const deleteAnswerButton = document.createElement("button");
    deleteAnswerButton.innerHTML = "Supprimer";
    deleteAnswerButton.className = "btn btn-outline-danger btn-sm";

    deleteAnswerButton.addEventListener ("click", function() {
        // Remove the answer
        div.remove();
    });
    // Add the button to the answer
    div.append(deleteAnswerButton);
}
