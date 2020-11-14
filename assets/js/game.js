// variables
var imagePath = base_url + 'assets/images/';
var personId = '';
var personHasAlreadyChosen = false;
var gameId = '';
var gameBudget = '0';
var correctAccessCode = '';
var chosenPerson;


function ucFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function updateImage(imageSource, image_destination) {
    image_destination.attr('src', imageSource);
}

function verifyCodeListener(accessCode_input_control) {
	accessCode_input_control.keyup(function () {
		var accessCode = $(this).val();

		if (accessCode.length === 4) {
			$.ajax({
				type: "POST",
				url: site_url + "/game/ajaxVerifyAccessCode",
				data: {accessCode: accessCode},
				dataType: "json",
				success: function (result) {
					if (result['userId'] > 0) {
						window.location.href = site_url + "game/home";
					}
					// else -> do nothing
				},
				error: function (xhr, status, error) {
					console.log("-- ERROR IN AJAX --\n\n" + xhr.responseText);
				}
			});
		}
	});
}

//get unchosen persons that is't the player-person
function showPossiblePersons(currentPersonId, gameId, gameBudget, image_right, resultWrapper) {
	$.ajax({
        type: "POST",
        url: site_url + "/game/ajaxGetRandomPerson",
        data: {currentPersonId: currentPersonId, gameId: gameId},
        dataType: "json",
        success: function (result) {
            // get data from result
            var allPersonsImageNames = result['allPersonsImageNames'];
            var numberOfAllPersons = allPersonsImageNames.length;
            chosenPerson = result['randomPerson'];

            // show random images
            var i;
            var intervalTime = 0;
            var randomIndex = 0;
            var previousIndex = 0;
            for (i = 0; i < 16; i++) {

                setTimeout(function () {
                    randomIndex = Math.floor(Math.random() * (numberOfAllPersons - 1));

                    while (randomIndex === previousIndex) {
                        randomIndex = Math.floor(Math.random() * (numberOfAllPersons - 1));
                    }
                    previousIndex = randomIndex;
                    updateImage(imagePath + allPersonsImageNames[randomIndex] + '.jpg', image_right);
                }, intervalTime);
                intervalTime += 250;
            }

            setTimeout(function () {
                updateImage(imagePath + chosenPerson.image + '.jpg', image_right);

                var resultMessage = "";
                if (chosenPerson.nickname === chosenPerson.name) {
                    resultMessage = 'You picked ' + ucFirst(chosenPerson.name) + ' ' + ucFirst(chosenPerson.lastname) + "!";

                } else {
                    resultMessage = 'You picked ' + ucFirst(chosenPerson.name) + ' ' + ucFirst(chosenPerson.lastname) + ' aka "' + ucFirst(chosenPerson.nickname) + '"!';
                }

                var resultPs = "";
                if (parseInt(chosenPerson.isMale) === 1) {
                    resultPs = "You can surprise him with a gift of €" + gameBudget;
                } else {
                    resultPs = "You can surprise her with a gift of €" + gameBudget;
                }
                resultWrapper.find('p.result').html(resultMessage);
                resultWrapper.find('p.result-ps').html(resultPs);
            }, 4000);

            $('#start-game').hide();
        },
        error: function (xhr, status, error) {
            console.log("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
}


function startButtonListener(startButton_control, controlsWrapper, resultWrapper, image_right) {
    startButton_control.click(function () {
    	personId  = $('#person-id').val();
		gameId  = $('#game-id').val();
		gameBudget  = $('#game-budget').val();

		// show message
		resultWrapper.find('p.result').html('Randomizing ... now');
        showPossiblePersons(personId, gameId, gameBudget, image_right, resultWrapper);
    });
}

$(document).ready(function () {
    var accessCode_input_control = $('input#accessCode');
    var image_right = $('img.img-chosen-person');
    var startButton_control = $('button#start-game');
    var controlsWrapper = $('div.controls-wrapper');
    var resultWrapper = $('div.result-wrapper');

    verifyCodeListener(accessCode_input_control);
    startButtonListener(startButton_control, controlsWrapper, resultWrapper, image_right);
});
