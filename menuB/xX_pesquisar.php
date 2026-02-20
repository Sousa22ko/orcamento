<?php
print ("<p><p><br>Pesquisa de Despesa ou valor:<p><br>");?>

<form action="busca_new.php" method="post">
Buscar por:
<input type="text" size="35" name="textoProcurado" class="searchinput" id="textoProcurado" onfocus="this.value = '';" />&nbsp;
<input type="text" size="35" name="valor" class="searchinput" id="valor"  onfocus="this.value = '';" />&nbsp;


<input type="submit" name="Submit" value="Busca">
</form>


