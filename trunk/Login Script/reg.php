<?php

?>
<form action="index.php?page=createacc" method="post">
<label for="username">Prospective Username:</label>
<input type="text" name="username" />
<br />
<label for="password">Password:</label><?php echo "\t\t\t"; ?>
<input type="password" name="password" />
<br />
<label for="email">Email Account:</label><?php echo "\t\t"; ?>
<input type="text" name="email" />
<br />
<input type="submit" name="submit" value="Register" />
</form>
