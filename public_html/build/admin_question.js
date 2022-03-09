(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["admin_question"],{

/***/ "./assets/js/admin/question.js":
/*!*************************************!*\
  !*** ./assets/js/admin/question.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! core-js/modules/es.array.find */ "./node_modules/core-js/modules/es.array.find.js");

__webpack_require__(/*! core-js/modules/es.regexp.exec */ "./node_modules/core-js/modules/es.regexp.exec.js");

__webpack_require__(/*! core-js/modules/es.string.replace */ "./node_modules/core-js/modules/es.string.replace.js");

var $collectionHolder; // setup an "add an answer" link

var $addAnswerButton = $('<button id="js-answer-add" type="button" class="btn btn-secondary js-answer-add">Ajouter une réponse</button>');
var $newAnswerDiv = $('<div></div>').append($addAnswerButton);
jQuery(document).ready(function () {
  // Get the div that holds the collection of answers
  $collectionHolder = $(".js-answers-wrapper"); // Add a delete button to all of the existing answer elements

  $collectionHolder.find('.js-answer').each(function () {
    addAnswerFormDeleteLink($(this));
  }); // Add the "add an answer" anchor

  $collectionHolder.append($newAnswerDiv); // count the current form inputs we have (e.g. 2), use that as the new
  // index when inserting a new item (e.g. 2)

  $collectionHolder.data('index', $collectionHolder.find('input').length);
  $addAnswerButton.on('click', function (e) {
    // add a new answer form (see next code block)
    addAnswerForm($collectionHolder, $newAnswerDiv);
  });
});

function addAnswerForm($collectionHolder, $newAnswerDiv) {
  // Get the data-prototype
  var prototype = $collectionHolder.data('prototype'); // Get the new index

  var index = $collectionHolder.data('index');
  var newForm = prototype; // Replace '__name__' in the prototype's HTML to
  // instead be a number based on how many items we have

  newForm = newForm.replace(/__name__/g, index); // Increase the index with one for the next item

  $collectionHolder.data('index', index + 1); // Display the form in the page in a div, before the "Add a answer" button

  var $newFormDiv = $('<div class="row mb-2"></div>').append(newForm);
  $newAnswerDiv.before($newFormDiv); // add a delete link to the new form

  addAnswerFormDeleteLink($newFormDiv);
}

function addAnswerFormDeleteLink($answerDiv) {
  var $removeFormButton = $('<button class="btn btn-outline-danger btn-sm">Supprimer</button>');
  $answerDiv.append($removeFormButton);
  $removeFormButton.on('click', function (e) {
    // remove the div for the answer form
    $answerDiv.remove();
  });
}

/***/ })

},[["./assets/js/admin/question.js","runtime","vendors~admin_question"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvYWRtaW4vcXVlc3Rpb24uanMiXSwibmFtZXMiOlsiJGNvbGxlY3Rpb25Ib2xkZXIiLCIkYWRkQW5zd2VyQnV0dG9uIiwiJCIsIiRuZXdBbnN3ZXJEaXYiLCJhcHBlbmQiLCJqUXVlcnkiLCJkb2N1bWVudCIsInJlYWR5IiwiZmluZCIsImVhY2giLCJhZGRBbnN3ZXJGb3JtRGVsZXRlTGluayIsImRhdGEiLCJsZW5ndGgiLCJvbiIsImUiLCJhZGRBbnN3ZXJGb3JtIiwicHJvdG90eXBlIiwiaW5kZXgiLCJuZXdGb3JtIiwicmVwbGFjZSIsIiRuZXdGb3JtRGl2IiwiYmVmb3JlIiwiJGFuc3dlckRpdiIsIiRyZW1vdmVGb3JtQnV0dG9uIiwicmVtb3ZlIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7Ozs7QUFBQSxJQUFJQSxpQkFBSixDLENBQ0E7O0FBQ0EsSUFBSUMsZ0JBQWdCLEdBQUdDLENBQUMsQ0FBQywrR0FBRCxDQUF4QjtBQUNBLElBQUlDLGFBQWEsR0FBR0QsQ0FBQyxDQUFDLGFBQUQsQ0FBRCxDQUFpQkUsTUFBakIsQ0FBd0JILGdCQUF4QixDQUFwQjtBQUNBSSxNQUFNLENBQUNDLFFBQUQsQ0FBTixDQUFpQkMsS0FBakIsQ0FBdUIsWUFBVztBQUM5QjtBQUNBUCxtQkFBaUIsR0FBR0UsQ0FBQyxDQUFDLHFCQUFELENBQXJCLENBRjhCLENBRzlCOztBQUNBRixtQkFBaUIsQ0FBQ1EsSUFBbEIsQ0FBdUIsWUFBdkIsRUFBcUNDLElBQXJDLENBQTBDLFlBQVc7QUFDakRDLDJCQUF1QixDQUFDUixDQUFDLENBQUMsSUFBRCxDQUFGLENBQXZCO0FBQ0gsR0FGRCxFQUo4QixDQU85Qjs7QUFDQUYsbUJBQWlCLENBQUNJLE1BQWxCLENBQXlCRCxhQUF6QixFQVI4QixDQVM5QjtBQUNBOztBQUNBSCxtQkFBaUIsQ0FBQ1csSUFBbEIsQ0FBdUIsT0FBdkIsRUFBZ0NYLGlCQUFpQixDQUFDUSxJQUFsQixDQUF1QixPQUF2QixFQUFnQ0ksTUFBaEU7QUFDQVgsa0JBQWdCLENBQUNZLEVBQWpCLENBQW9CLE9BQXBCLEVBQTZCLFVBQVNDLENBQVQsRUFBWTtBQUNyQztBQUNBQyxpQkFBYSxDQUFDZixpQkFBRCxFQUFvQkcsYUFBcEIsQ0FBYjtBQUNILEdBSEQ7QUFJSCxDQWhCRDs7QUFpQkEsU0FBU1ksYUFBVCxDQUF1QmYsaUJBQXZCLEVBQTBDRyxhQUExQyxFQUF5RDtBQUNyRDtBQUNBLE1BQUlhLFNBQVMsR0FBR2hCLGlCQUFpQixDQUFDVyxJQUFsQixDQUF1QixXQUF2QixDQUFoQixDQUZxRCxDQUdyRDs7QUFDQSxNQUFJTSxLQUFLLEdBQUdqQixpQkFBaUIsQ0FBQ1csSUFBbEIsQ0FBdUIsT0FBdkIsQ0FBWjtBQUNBLE1BQUlPLE9BQU8sR0FBR0YsU0FBZCxDQUxxRCxDQU1yRDtBQUNBOztBQUNBRSxTQUFPLEdBQUdBLE9BQU8sQ0FBQ0MsT0FBUixDQUFnQixXQUFoQixFQUE2QkYsS0FBN0IsQ0FBVixDQVJxRCxDQVNyRDs7QUFDQWpCLG1CQUFpQixDQUFDVyxJQUFsQixDQUF1QixPQUF2QixFQUFnQ00sS0FBSyxHQUFHLENBQXhDLEVBVnFELENBV3JEOztBQUNBLE1BQUlHLFdBQVcsR0FBR2xCLENBQUMsQ0FBQyw4QkFBRCxDQUFELENBQWtDRSxNQUFsQyxDQUF5Q2MsT0FBekMsQ0FBbEI7QUFDQWYsZUFBYSxDQUFDa0IsTUFBZCxDQUFxQkQsV0FBckIsRUFicUQsQ0FjckQ7O0FBQ0FWLHlCQUF1QixDQUFDVSxXQUFELENBQXZCO0FBQ0g7O0FBQ0QsU0FBU1YsdUJBQVQsQ0FBaUNZLFVBQWpDLEVBQTZDO0FBQ3pDLE1BQUlDLGlCQUFpQixHQUFHckIsQ0FBQyxDQUFDLGtFQUFELENBQXpCO0FBQ0FvQixZQUFVLENBQUNsQixNQUFYLENBQWtCbUIsaUJBQWxCO0FBQ0FBLG1CQUFpQixDQUFDVixFQUFsQixDQUFxQixPQUFyQixFQUE4QixVQUFTQyxDQUFULEVBQVk7QUFDdEM7QUFDQVEsY0FBVSxDQUFDRSxNQUFYO0FBQ0gsR0FIRDtBQUlILEMiLCJmaWxlIjoiYWRtaW5fcXVlc3Rpb24uanMiLCJzb3VyY2VzQ29udGVudCI6WyJ2YXIgJGNvbGxlY3Rpb25Ib2xkZXI7XHJcbi8vIHNldHVwIGFuIFwiYWRkIGFuIGFuc3dlclwiIGxpbmtcclxudmFyICRhZGRBbnN3ZXJCdXR0b24gPSAkKCc8YnV0dG9uIGlkPVwianMtYW5zd2VyLWFkZFwiIHR5cGU9XCJidXR0b25cIiBjbGFzcz1cImJ0biBidG4tc2Vjb25kYXJ5IGpzLWFuc3dlci1hZGRcIj5Bam91dGVyIHVuZSByw6lwb25zZTwvYnV0dG9uPicpO1xyXG52YXIgJG5ld0Fuc3dlckRpdiA9ICQoJzxkaXY+PC9kaXY+JykuYXBwZW5kKCRhZGRBbnN3ZXJCdXR0b24pO1xyXG5qUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xyXG4gICAgLy8gR2V0IHRoZSBkaXYgdGhhdCBob2xkcyB0aGUgY29sbGVjdGlvbiBvZiBhbnN3ZXJzXHJcbiAgICAkY29sbGVjdGlvbkhvbGRlciA9ICQoXCIuanMtYW5zd2Vycy13cmFwcGVyXCIpO1xyXG4gICAgLy8gQWRkIGEgZGVsZXRlIGJ1dHRvbiB0byBhbGwgb2YgdGhlIGV4aXN0aW5nIGFuc3dlciBlbGVtZW50c1xyXG4gICAgJGNvbGxlY3Rpb25Ib2xkZXIuZmluZCgnLmpzLWFuc3dlcicpLmVhY2goZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgYWRkQW5zd2VyRm9ybURlbGV0ZUxpbmsoJCh0aGlzKSk7XHJcbiAgICB9KTtcclxuICAgIC8vIEFkZCB0aGUgXCJhZGQgYW4gYW5zd2VyXCIgYW5jaG9yXHJcbiAgICAkY29sbGVjdGlvbkhvbGRlci5hcHBlbmQoJG5ld0Fuc3dlckRpdik7XHJcbiAgICAvLyBjb3VudCB0aGUgY3VycmVudCBmb3JtIGlucHV0cyB3ZSBoYXZlIChlLmcuIDIpLCB1c2UgdGhhdCBhcyB0aGUgbmV3XHJcbiAgICAvLyBpbmRleCB3aGVuIGluc2VydGluZyBhIG5ldyBpdGVtIChlLmcuIDIpXHJcbiAgICAkY29sbGVjdGlvbkhvbGRlci5kYXRhKCdpbmRleCcsICRjb2xsZWN0aW9uSG9sZGVyLmZpbmQoJ2lucHV0JykubGVuZ3RoKTtcclxuICAgICRhZGRBbnN3ZXJCdXR0b24ub24oJ2NsaWNrJywgZnVuY3Rpb24oZSkge1xyXG4gICAgICAgIC8vIGFkZCBhIG5ldyBhbnN3ZXIgZm9ybSAoc2VlIG5leHQgY29kZSBibG9jaylcclxuICAgICAgICBhZGRBbnN3ZXJGb3JtKCRjb2xsZWN0aW9uSG9sZGVyLCAkbmV3QW5zd2VyRGl2KTtcclxuICAgIH0pO1xyXG59KTtcclxuZnVuY3Rpb24gYWRkQW5zd2VyRm9ybSgkY29sbGVjdGlvbkhvbGRlciwgJG5ld0Fuc3dlckRpdikge1xyXG4gICAgLy8gR2V0IHRoZSBkYXRhLXByb3RvdHlwZVxyXG4gICAgdmFyIHByb3RvdHlwZSA9ICRjb2xsZWN0aW9uSG9sZGVyLmRhdGEoJ3Byb3RvdHlwZScpO1xyXG4gICAgLy8gR2V0IHRoZSBuZXcgaW5kZXhcclxuICAgIHZhciBpbmRleCA9ICRjb2xsZWN0aW9uSG9sZGVyLmRhdGEoJ2luZGV4Jyk7XHJcbiAgICB2YXIgbmV3Rm9ybSA9IHByb3RvdHlwZTtcclxuICAgIC8vIFJlcGxhY2UgJ19fbmFtZV9fJyBpbiB0aGUgcHJvdG90eXBlJ3MgSFRNTCB0b1xyXG4gICAgLy8gaW5zdGVhZCBiZSBhIG51bWJlciBiYXNlZCBvbiBob3cgbWFueSBpdGVtcyB3ZSBoYXZlXHJcbiAgICBuZXdGb3JtID0gbmV3Rm9ybS5yZXBsYWNlKC9fX25hbWVfXy9nLCBpbmRleCk7XHJcbiAgICAvLyBJbmNyZWFzZSB0aGUgaW5kZXggd2l0aCBvbmUgZm9yIHRoZSBuZXh0IGl0ZW1cclxuICAgICRjb2xsZWN0aW9uSG9sZGVyLmRhdGEoJ2luZGV4JywgaW5kZXggKyAxKTtcclxuICAgIC8vIERpc3BsYXkgdGhlIGZvcm0gaW4gdGhlIHBhZ2UgaW4gYSBkaXYsIGJlZm9yZSB0aGUgXCJBZGQgYSBhbnN3ZXJcIiBidXR0b25cclxuICAgIHZhciAkbmV3Rm9ybURpdiA9ICQoJzxkaXYgY2xhc3M9XCJyb3cgbWItMlwiPjwvZGl2PicpLmFwcGVuZChuZXdGb3JtKTtcclxuICAgICRuZXdBbnN3ZXJEaXYuYmVmb3JlKCRuZXdGb3JtRGl2KTtcclxuICAgIC8vIGFkZCBhIGRlbGV0ZSBsaW5rIHRvIHRoZSBuZXcgZm9ybVxyXG4gICAgYWRkQW5zd2VyRm9ybURlbGV0ZUxpbmsoJG5ld0Zvcm1EaXYpO1xyXG59XHJcbmZ1bmN0aW9uIGFkZEFuc3dlckZvcm1EZWxldGVMaW5rKCRhbnN3ZXJEaXYpIHtcclxuICAgIHZhciAkcmVtb3ZlRm9ybUJ1dHRvbiA9ICQoJzxidXR0b24gY2xhc3M9XCJidG4gYnRuLW91dGxpbmUtZGFuZ2VyIGJ0bi1zbVwiPlN1cHByaW1lcjwvYnV0dG9uPicpO1xyXG4gICAgJGFuc3dlckRpdi5hcHBlbmQoJHJlbW92ZUZvcm1CdXR0b24pO1xyXG4gICAgJHJlbW92ZUZvcm1CdXR0b24ub24oJ2NsaWNrJywgZnVuY3Rpb24oZSkge1xyXG4gICAgICAgIC8vIHJlbW92ZSB0aGUgZGl2IGZvciB0aGUgYW5zd2VyIGZvcm1cclxuICAgICAgICAkYW5zd2VyRGl2LnJlbW92ZSgpO1xyXG4gICAgfSk7XHJcbn0iXSwic291cmNlUm9vdCI6IiJ9