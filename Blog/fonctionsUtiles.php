<?php
    class FontStyle{
        public const ITALIC = "italic";
    }

//Fonction permettant d'afficher les messages d'erreurs
    function showMsgErreur(?string $msg, string $color = "#ba0707", ?string $style = null): void {
        if(null === $msg || !isset($msg)){
            return;
        }
        echo "<span style ='color: $color'>" . ($style === FontStyle::ITALIC ? '<i>' : '') . $msg . ($style === FontStyle::ITALIC ? '<i>' : '') . "</span>";
    }

?>