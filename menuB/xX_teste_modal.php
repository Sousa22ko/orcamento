<HTML>

<HEAD>
    <TITLE>New Document</TITLE>
</HEAD>

<BODY>

    <?php
    require ("orcamento.inc");
    require ("functions.inc");
    $indice = '5238';

    $query = "SELECT $dbname.despesa.*,$dbname_aux.descricao.*
          FROM $dbname.despesa ,$dbname_aux.descricao
          WHERE $dbname.despesa.valido='S'
          AND $dbname.despesa.id_descricao=$dbname_aux.descricao.id_descricao
          AND $dbname.despesa.id_despesa=" . $indice;

    //print "$query";
    // Executa a primeira query sql
    
    $result = mysqli_query($mysqli_connection, $query) ;

    //$result = mysqli_query ($query, $link) or die ("N�o consegui consultar" . $query . mysql_error());
    

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    //$row = mysqli_fetch_array($result);


    ?>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="css/bootstrap-datepicker.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>


    <title>Orcamento</title>
    </head>


    <div class='container-fluid'>

        <div class='modal-fade bd-example-modal-lg' tabindex='-10' role='dialog' aria-labelledby='exampleModalLabel'
            aria-hidden='true'>


            <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>



                        <div class='d-flex flex-column bd-highlight mb-3'>
                            <div class="row">

                                <div class='p-2 bd-highlight'>
                                    <div class='col-md-2'>Despesa</div>
                                    <div class='col-md-2'><INPUT style=WIDTH: 30px; HEIGHT: 20px size=15 type='text'
                                            name=despesa value=<? echo $row["despesa"]; ?>> </div>
                                </div>


                                <div class='p-2 bd-highlight'>
                                    <div class='col-md-1'>Valor</div>
                                    <div class='col-md-1'><INPUT style=WIDTH: 30px; HEIGHT: 20px size=4 type='text'
                                            name=valor value=<? echo $row["valor"]; ?>> </div>
                                </div>



                                <div class='p-2 bd-highlight'>
                                    <div class='col-md-1'>Data</div>
                                    <div class='col-md-1'><INPUT style=WIDTH: 30px; HEIGHT: 20px size=6 type='text'
                                            name=data value=<? echo date("d/m/Y", (strtotime($row["data"]))); ?>> </div>
                                </div>

                                <div class='p-2 bd-highlight'>
                                    <div class='col-md-1'>Parcela</div>
                                    <div class='col-md-1'><INPUT style=WIDTH: 30px; HEIGHT: 20px size=3 type='text'
                                            name=despesa value=<? print $row["parcela"] ?>> </div>
                                </div>

                            </div>
                        </div>


                        <div class='d-flex flex-column bd-highlight mb-3'>
                            <div class="row">
                                <div class='p-2 bd-highlight'>
                                    <div class='col-md-1'>Vencimento</div>
                                    <div class='col-md-1'><input style='WIDTH: 80px' name=vencimento
                                            value="<? echo date("d/m/Y", (strtotime($row["vencimento"]))) ?>"></div>
                                </div>

                                <div class='p-2 bd-highlight'>
                                    <div class='col-md-2'>Descricao
                                        <?php
                                        //****************** Obtem os tipos de despesas ************ -->
                                        $result = obtem_dados_aux("descricao", "descricao_abreviada", "asc") or die(mysql_error());
                                        $linhas = mysqli_num_rows($result);
                                        for ($i = 0; $i < $linhas; $i++) {
                                            $array[$i] = mysqli_fetch_array($result);
                                        }
                                        print ("<div class='col-md-2'>
                                          <select size=1 name=id_descricao>");

                                        for ($i = 0; $i < $linhas; $i++) {
                                            if ($array[$i][0] == $row["id_descricao"])
                                                print "<option Value=" . $array[$i][0] . " selected>" . $array[$i][2] . "</option>";
                                            else
                                                print "<option Value=" . $array[$i][0] . ">" . $array[$i][2] . "</option>";
                                        }
                                        print ("</select></div>");
                                        //********************** Fim ***************************** -->
                                        
                                        ?>
                                    </div>
                                </div>






                            </div>
                            <div class='p-2 bd-highlight'>Flex item 3</div>
                        </div>











                        <div class='row'>
                            <div class="col py-5 px-md-15 border bg-light">
                                <div class='col-md-1'>Vencimento</div>
                                <div class='col-md-1'><input style='WIDTH: 80px' name=vencimento
                                        value="<? echo date("d/m/Y", (strtotime($row["vencimento"]))) ?>"></div>



                                <div class='row'>
                                    <div class='col-md-1'> Categoria
                                        <?
                                        //****************** Obtem os tipos de despesas ************ -->
                                        $result = obtem_dados_aux("categoria", "nome_categoria", "asc") or die(mysql_error());
                                        $linhas = mysqli_num_rows($result);
                                        for ($i = 0; $i < $linhas; $i++) {
                                            $array[$i] = mysqli_fetch_array($result);
                                        }
                                        print ("<div class='col-md-1'>
                                                 <select size=1 name=categoria>");

                                        for ($i = 0; $i < $linhas; $i++) {
                                            if ($array[$i][0] == $row["categoria"])
                                                print "<option Value=" . $array[$i][0] . " selected>" . $array[$i][1] . "</option>";
                                            else
                                                print "<option Value=" . $array[$i][0] . ">" . $array[$i][1] . "</option>";
                                        }
                                        print ("</select>");
                                        //********************** Fim ***************************** -->
                                        ?>
                                    </div>


                                    <div class='row'>
                                        <div class='modal-footer'> </div>
                                        <div class='col-md-1'> excl
                                            <div class='col-md-1'><a href=<? echo $row["id_despesa"]; ?>><img
                                                        src='imagem/lixeira.jpg' width='32' height='32' border='0'
                                                        alt='modificar'></a></div>
                                        </div>





                                        <div class='modal-dialog modal-dialog-centered' role='document'>
                                            <button type='button' class='btn btn-secondary'
                                                data-dismiss='modal'>Fechar</button>
                                            <button type='button' class='btn btn-primary'>Salvar mudan�as</button>
                                        </div>





                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    ");



                    <script type="text/javascript">
                        $('#exemplo').datepicker({
                            format: "dd/mm/yyyy",
                            language: "pt-BR",
                            startDate: '-30d',
                            autoclose: true,

                        });
                    </script>


                    <script type="text/javascript">
                        $('#exemplo2').datepicker({
                            format: "mm/yyyy",
                            language: "pt-BR",
                            startDate: '+0d',
                            startView: 'months',
                            minViewMode: 'months',
                            autoclose: true,
                        });
                    </script>




                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




</BODY>

</HTML>