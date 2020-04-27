$(document).ready(function () {
    $('#create_survey_user').form({
        fields: {
            c_mat_nr: {
                identifier: 'c_mat_nr',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Bitte Matrikelnummer eingeben'
                    },
                    {
                        type   : 'length[7]',
                        prompt : 'Die Matrikelnummer an der DHBW muss 7 Zeichen lang sein'
                    }
                ]
            },
            c_name: {
                identifier: 'c_name',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Bitte Namen eingeben'
                    },
                    {
                        type   : 'length[4]',
                        prompt : 'Mindestlänge für Namen ist 4 Zeichen'
                    }
                ]
            }
        }
    });
});