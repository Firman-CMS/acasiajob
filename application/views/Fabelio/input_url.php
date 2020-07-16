<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Input Form</title>
</head>
<body>
    <form action="/fabelio/result" method="POST">
        <fieldset>
        <legend>Page 1</legend>
        <p>
            <label>Fabelio product url:</label>
            <input type="text" name="url" placeholder="Url product..." />
        </p>
        <p>
            <input type="submit" name="submit" value="submit" />
        </p>
        </fieldset>
    </form>
     <a href="/fabelio/list">Page 2</a> |
     <a href="/fabelio/result">Page 3</a> 
</body>
</html>