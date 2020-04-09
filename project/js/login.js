$(document).ready(function () {
    $('#login').form({
        fields: {
            email: {
                identifier: 'user',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Please enter your Username'
                    }
                ]
            },
            password: {
                identifier: 'pass',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Please enter your password'
                    }
                ]
            }
        }
    });
});