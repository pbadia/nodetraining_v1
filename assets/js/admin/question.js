var $collectionHolder;
// setup an "add an answer" link
var $addAnswerButton = $('<button id="js-answer-add" type="button" class="btn btn-secondary js-answer-add">Ajouter une réponse</button>');
var $newAnswerDiv = $('<div></div>').append($addAnswerButton);

// JQuery
/*jQuery(document).ready(function() {
    // Get the div that holds the collection of answers
    $collectionHolder = $(".js-answers-wrapper");
    // Add a delete button to all of the existing answer elements
    $collectionHolder.find('.js-answer').each(function() {
        addAnswerFormDeleteLink($(this));
    });
    // Add the "add an answer" anchor
    $collectionHolder.append($newAnswerDiv);
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('input').length);
    $addAnswerButton.on('click', function(e) {
        // add a new answer form (see next code block)
        addAnswerForm($collectionHolder, $newAnswerDiv);
    });
});*/
// Vanilla js
document.addEventListener("DOMContentLoaded", function() {
    // Get the div that holds the collection of answers
    $collectionHolder = $(".js-answers-wrapper");
    // Add a delete button to all of the existing answer elements
    $collectionHolder.find('.js-answer').each(function() {
        addAnswerFormDeleteLink($(this));
    });
    // Add the "add an answer" anchor
    $collectionHolder.append($newAnswerDiv);
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('input').length);
    $addAnswerButton.on('click', function(e) {
        // add a new answer form (see next code block)
        addAnswerForm($collectionHolder, $newAnswerDiv);
    });
});

function addAnswerForm($collectionHolder, $newAnswerDiv) {
    // Get the data-prototype
    var prototype = $collectionHolder.data('prototype');
    // Get the new index
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);
    // Increase the index with one for the next item
    $collectionHolder.data('index', index + 1);
    // Display the form in the page in a div, before the "Add a answer" button
    var $newFormDiv = $('<div class="row mb-2"></div>').append(newForm);
    $newAnswerDiv.before($newFormDiv);
    // add a delete link to the new form
    addAnswerFormDeleteLink($newFormDiv);
}
function addAnswerFormDeleteLink($answerDiv) {
    var $removeFormButton = $('<button class="btn btn-outline-danger btn-sm">Supprimer</button>');
    $answerDiv.append($removeFormButton);
    $removeFormButton.on('click', function(e) {
        // remove the div for the answer form
        $answerDiv.remove();
    });
}