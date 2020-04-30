$(document).ready(function () {
    $('#create_course').form({
        fields: {
            c_course_short: {
                identifier: 'c_course_short',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Bitte K&uuml;rzel eingeben'
                    },
                    {
                        type   : 'length[2]',
                        prompt : 'Das K&uuml;rzel muss mindestens 2 Zeichen lang sein'
                    }
                ]
            },
            c_course: {
                identifier: 'c_course',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Bitte Kurs eingeben'
                    },
                    {
                        type   : 'length[4]',
                        prompt : 'Der Kurs Bezeichner muss mindestens 4 Zeichen lang sein'
                    }
                ]
            }
        }
    });
});