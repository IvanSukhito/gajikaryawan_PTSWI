function submitAnswer() {
    $('input[name="answer"]').prop('disabled', true);
    $('#timer-tick').text('Submitting...');
    var data = {
        question_id : $('#question_id').val(),
        answer      : $('input[name="answer"]:checked').val(),
        expired     : $('#expired').val(),
        _token      : $('input[name="_token"]').val()
    };
    $.post(saveUrl, data, function(res) {
        $('#timer-tick').text('Done');
        var cl = res.is_correct == true ? 'true' : 'false';
        $('.trivia-true-false .' + cl + ' h3').text(res.message);
        $('.trivia-true-false, .trivia-true-false .' + cl).removeClass('d-none');
        setTimeout(function() {
            window.location.replace(playUrl);
        }, 2000);
    }, 'json')
}

$(function() {
    var timerTicking = function() {
        duration--;
        if (duration >= 0) {
            $('#timer-tick').text(duration);
        } else {
            $('#expired').val('1');
            clearInterval(timer);
            submitAnswer();
        }
    }
    var timer = setInterval(timerTicking, 1000);
    
    $('input[name="answer"]').change(function() {
        clearInterval(timer);
        submitAnswer();
    })
})