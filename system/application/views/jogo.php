<?php if(!isset($fim)) $fim = false;?><html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
        <title>Jogo da forca</title>
        <script type="text/javascript">
<?php if (isset($fim) && $fim) { ?>
                    alert("PARABÉNS!!!");
<?php } ?>
                function js_escolheLetra(asc){
                    document.location.href = "/jogoforca/index.php/jogo/escolhe_letra/" + asc;
                }

                function js_trocaPalavra(){
                    document.location.href = "/jogoforca/index.php/jogo/troca_palavra";
                }

        </script>
    </head>
    <body>
        <h1>Jogo da forca</h1>
        Palavra: <?php echo $palavra; ?> <br><br>
        Pontuação: <?php echo $pontuacao; ?>
        <br><br>
        <?php
        if (!$fim) {
            for ($i = 65; $i < 91; $i++) {
                echo "<button onclick=\"js_escolheLetra('$letras[$i]');\">" . $letras[$i] . " </button>";
            }
        }
        ?>
        <br>
        <br>
        <button onclick="js_trocaPalavra();">Troca palavra</button>
    </body>
</html>