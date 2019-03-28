// variables
var imagePath = base_url + 'assets/images/';
var personId = '';
var personHasAlreadyChosen = false;
var gameId = '';
var correctAccessCode = '';
var chosenPerson;


function ucFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function chooseYourselfDropdownListener(chooseYourSelf_dropdown_control, accessCode_input_control, image_left) {
    chooseYourSelf_dropdown_control.change(function () {
        personId = chooseYourSelf_dropdown_control.find('option:selected').val();
        gameId = chooseYourSelf_dropdown_control.find('option:selected').data('game-id');

        var chosenPersonId = chooseYourSelf_dropdown_control.find('option:selected').data('token');
        if (chosenPersonId !== -1) {
            personHasAlreadyChosen = true;
        }
        var personImageName = chooseYourSelf_dropdown_control.find('option:selected').data('image');
        correctAccessCode = chooseYourSelf_dropdown_control.find('option:selected').data('access-code');
        updateImage(imagePath + personImageName + '.jpg', image_left);
        updateAccessCodeControl(accessCode_input_control, personImageName);
        enableOrDisableAccessCodeInput(personId, accessCode_input_control);
    });
}

function updateImage(imageSource, image_destination) {
    image_destination.attr('src', imageSource);
}


function updateAccessCodeControl(accessCode_input_control, personImageName) {
    accessCode_input_control.val('');
    if (personImageName != 'empty') {
        accessCode_input_control.attr('placeholder', 'Code');
    } else {
        accessCode_input_control.attr('placeholder', '');
    }
}

function enableOrDisableAccessCodeInput(personId, accessCode_input_control) {
    if (parseInt(personId) > 0) {
        accessCode_input_control.removeAttr('disabled');
    }
    else {
        accessCode_input_control.attr('disabled', 'disabled');
    }
}

function accessCodeInputListener(accessCode_input_control, startButton_control, imageWrapper, controlsWrapper, errorWrapper) {
    accessCode_input_control.keyup(function () {
        var accessCode = $(this).val();
        if (accessCode.length === 4) {
            if (parseInt(accessCode) === correctAccessCode) {
                // check if this person already has chosen a person
                if (personHasAlreadyChosen) {
                    controlsWrapper.hide();
                    imageWrapper.hide();
                    errorWrapper.show();
                } else {
                    startButton_control.removeAttr('disabled');
                    startButton_control.html('Start !');
                }
            } else {
                startButton_control.attr('disabled', 'disabled');
                startButton_control.html('');
            }
        }
    });
}

//get unchosen persons that is't the player-person
function showPossiblePersons(currentPersonId, gameId, image_right, messageWrapper, resultWrapper) {
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
                    resultMessage = 'You picked "' + ucFirst(chosenPerson.nickname) + '" aka ' + ucFirst(chosenPerson.name) + ' ' + ucFirst(chosenPerson.lastname) + "!";
                }

                var resultPs = "";
                if (chosenPerson.isMale === "1") {
                    resultPs = "You can suprise him with a gift of € 20.";
                } else {
                    resultPs = "You can suprise her with a gift of € 20.";
                }
                resultWrapper.find('p.result').html(resultMessage);
                resultWrapper.find('p.result-ps').html(resultPs);
                messageWrapper.hide();
                resultWrapper.show();
            }, 4000);
        },
        error: function (xhr, status, error) {
            console.log("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
}


function startButtonListener(startButton_control, controlsWrapper, messageWrapper, resultWrapper, image_right) {
    startButton_control.click(function () {
        controlsWrapper.hide();
        messageWrapper.show();
        showPossiblePersons(personId, gameId, image_right, messageWrapper, resultWrapper);
    });
}

$(document).ready(function () {
    var chooseYourSelf_dropdown_control = $('#select-yourself-dropdown');
    var accessCode_input_control = $('input#accessCode');
    var image_left = $('img.img-person-that-will-choose');
    var image_right = $('img.img-choosen-person');
    var startButton_control = $('button#start-game');
    var imageWrapper = $('div.image-wrapper');
    var controlsWrapper = $('div.controls-wrapper');
    var messageWrapper = $('div.message-wrapper');
    var resultWrapper = $('div.result-wrapper');
    var errorWrapper = $('div.error-wrapper');

    chooseYourselfDropdownListener(chooseYourSelf_dropdown_control, accessCode_input_control, image_left);
    accessCodeInputListener(accessCode_input_control, startButton_control, imageWrapper, controlsWrapper, errorWrapper);
    startButtonListener(startButton_control, controlsWrapper, messageWrapper, resultWrapper, image_right);
});
