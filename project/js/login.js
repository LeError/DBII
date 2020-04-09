$(document).ready(function () {
    $('#login').form({
        fields: {
            email: {
                identifier: 'user',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Please enter your Username'
                    },
                    {
                        type   : 'length[6]',
                        prompt : 'Your Username must be at least 6 characters long'
                    }
                ]
            },
            password: {
                identifier: 'pass',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Please enter your password'
                    },
                    {
                        type   : 'length[8]',
                        prompt : 'Your password must be at least 8 characters long'
                    }
                ]
            }
        }
    });
});