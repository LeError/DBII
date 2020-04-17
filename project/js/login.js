$(document).ready(function () {
    $('#login').form({
        fields: {
            ul_user: {
                loginUser: 'ul_user',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Please enter your Username'
                    },
                    {
                        type   : 'length[4]',
                        prompt : 'Your Username must be at least 4 characters long'
                    }
                ]
            },
            ul_pass: {
                identifier: 'ul_pass',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Please enter your password'
                    },
                    {
                        type   : 'length[4]',
                        prompt : 'Your password must be at least 4 characters long'
                    }
                ]
            }
        }
    });
    $('#login_survey_user').form({
        fields: {
            identifier: 'sul_identifier',
            rules: [
                {
                    type: 'empty',
                    prompt: 'Please enter your Matricule Number!'
                },
                {
                    type   : 'length[7]',
                    prompt : 'Your Matricule Number is 7 Characters Long!'
                }
            ]
        }
    });
});