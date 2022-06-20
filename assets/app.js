
$(function () {
    $('#add_post').click(function () {
        let name = $('#nameFromPost').val();
        let content = $('#content').val();
        $.post(
            'index.php',
            {
                name: name,
                content: content,
            },
            function(){
            }
        );
    });


    $('.buttonAddComment').click(function(e) {
        let postId = $(e.currentTarget).data('comment');
        $('#post_id').val(postId);

        $('#add_message').click(function () {
            let name = $('#nameFromComment').val();
            let messageContent = $('#message').val();
            let id = $('#post_id').val();
            $.post(
                'index.php',
                {
                    name: name,
                    message: messageContent,
                    post_id: id,
                },
                function(){
                }
            );
        });
    });


    $(".stars").click(function(e) {
        e.preventDefault();
        let currentInput = e.currentTarget.previousElementSibling;
        let grade = currentInput.value;
        let postId = currentInput.parentElement.parentElement.id;
        let userName = $("#user-rating_" + postId)[0].value;

        $('#grade_' + postId).val(grade);
        let gradeVal = $('#grade_' + postId).val();
        console.log(gradeVal);

        let idButtonSubmit = '#submit-btn-' + postId;
        document.querySelector(idButtonSubmit).click(e => e.preventDefault());

        $(idButtonSubmit).click(function() {
            $.post(
                'index.php',
                {
                    grade: gradeVal,
                    post_id: postId,
                    name: userName,
                },
                function(){
                }
            );
        });
    });

    function CookiesDelete() {
        var cookies = document.cookie.split(";");
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;";
            document.cookie = name + '=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            document.cookie = name + '=; path=/index.php; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }
    }

    $(window).on('beforeunload', function(e) {
        CookiesDelete();
    });

});

