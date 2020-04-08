<div class="ui container">

    <br>

    <form method="post">
        <table width="50%" border="0"  cellspacing="10px">
            <tr>
                <th align="left" colspan="2">Create survey</th>
            </tr>
            <tr>
                <td>Titel:</td>
                <td><input maxlength="100" name="createSurvey[]" type="text" size="45"/></td>
            </tr>
            <tr>
                <td>Titel short:</td>
                <td><input maxlength="10" name="createSurvey[]" type="text"     /></td>
            </tr>
            <tr>
                <td>Number of questions:</td>
                <td><input  min="1" value="1" name="createSurvey[]" type="number" /></td>
            </tr>
            <tr>

                <td align="left" colspan="2"><input type="submit" value="Create questions" name="createQuestion"></td>
            </tr>
        </table>

    </form>
</div>