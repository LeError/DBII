<div class="ui container">

    <br>

    form

    Form for creating a survey, title short, title, number of questions

    @author     Moritz Bürkle

    <form method="post" action="../logic/createSurvey.php">
        <table width="50%" border="0"  cellspacing="10px">
            <tr>
                <th align="left" colspan="2">Create survey</th>
            </tr>
            <tr>
                <td>Titel:</td>
                <td><input maxlength="100" name="title" type="text" size="45"/></td>
            </tr>
            <tr>
                <td>Titel short:</td>
                <td><input maxlength="10" name="titleShort" type="text"     /></td>
            </tr>
            <tr>
                <td>Number of questions:</td>
                <td><input  min="1" value="1" name="numberOfQuestions" type="number" /></td>
            </tr>
            <tr>

                <td align="left" colspan="2"><input type="submit" value="Create questions" name="createQuestion"></td>
            </tr>
        </table>
    </form>
</div>