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
                        type   : 'length[4]',
                        prompt : 'Your Username must be at least 4 characters long'
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
                        type   : 'length[4]',
                        prompt : 'Your password must be at least 4 characters long'
                    }
                ]
            }
        }
    });
});