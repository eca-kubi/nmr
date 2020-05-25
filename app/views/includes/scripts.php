<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-mutation-observer/mutation-summary.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-mutation-observer/jquery-mutation-observer.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-ui/effects-core.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/moment/moment.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/bootstrap/bootstrap.bundle.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/bootnavbar/js/bootnavbar.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/adminlte/adminlte.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jszip/jszip.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/kendo-ui/kendo.all.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/letter-avatar/letter-avatar.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-scrollTo/jquery.scrollTo.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-toast/jquery-toast.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/jquery-dim-background/jquery-dim-background.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/clipboardjs/clipboard.min.js"></script>
<!--<script src="<?php /*echo URL_ROOT; */?>/public/assets/js/interactjs/interact.min.js"></script>
-->
<!--<script src="<?php /*echo URL_ROOT; */?>/public/assets/js/subjx/subjx.min.js"></script>
-->
<!--<script src="<?php /*echo URL_ROOT; */?>/public/assets/js/displace/displace.min.js"></script>
-->
<script src="<?php echo URL_ROOT; ?>/public/assets/js/pako-deflate/pako-deflate.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/js/pdfjs/pdf.js"></script>
<!--<script src="<?php /*echo URL_ROOT; */?>/public/assets/js/toc/tocbot.min.js"></script>
-->
<script src="<?php echo URL_ROOT; ?>/public/assets/ckfinder/ckfinder.js"></script>
<script src="<?php echo URL_ROOT; ?>/public/assets/ckeditor/ckeditor.js"></script>
<script>
    window.pdfjsLib.GlobalWorkerOptions.workerSrc = '<?php echo URL_ROOT; ?>/public/assets/js/pdfjs/pdf.worker.js';
    let URL_ROOT = "<?php echo URL_ROOT; ?>";
    kendo.pdf.defineFont({
        "Arial" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/arial.ttf'?>",
        "Arial|Italic" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/ArialI.ttf'?>",
        "Arial|Bold" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/arialbd.ttf'?>",
        "Arial|Bold|Italic" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/ArialBoldItalic.ttf'?>",
        "Comic Sans MS" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/ComicSansMS3.ttf'?>",
        "Comic Sans MS|Italic" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/comici.ttf'?>",
        "Comic Sans MS|Bold" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/ComicSansMSBold.ttf'?>",
        "Comic Sans MS|Bold|Italic" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/comicz.ttf'?>",
        "Calibri"  : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/calibri.ttf'?>",
        "Calibri|Bold"  : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/calibrib.ttf'?>",
        "Calibri|Italic"  : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/calibrii.ttf'?>",
        "Calibri|Bold|Italic"  : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/calibriz.ttf'?>",
        "Calibri Light"  : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/calibril.ttf'?>",
        "Calibri Light|Italic"  : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/calibrili.ttf'?>",
        "Times New Roman" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/times.ttf'?>",
        "Times New Roman|Bold" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/timesbd.ttf'?>",
        "Times New Roman|Italic" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/timesi.ttf'?>",
        "Times New Roman|Bold|Italic" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/timesbi.ttf'?>",
        "Verdana" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/verdana.ttf'?>",
        "Verdana|Bold" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/VerdanaBold.ttf'?>",
        "Verdana|Italic" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/VerdanaItalic.ttf'?>",
        "Verdana|Bold|Italic" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/verdanaz.ttf'?>",
        "Georgia" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/georgia/Georgia Regular font.ttf'?>",
        "Georgia|Bold" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/georgia/georgia bold.ttf'?>",
        "Georgia|Italic" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/georgia/georgia italic.ttf'?>",
        "Georgia|Bold|Italic" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/georgia/georgia bold italic.ttf'?>",
        "Segoe UI Symbol" : "<?php echo URL_ROOT .'/public/assets/fonts/font-face/fonts/segoeuisymbol/segoe-ui-symbol.ttf'?>"
    });
</script>
<script src="<?php echo URL_ROOT; ?>/public/custom-assets/js/custom.js?t=<?php echo now(); ?>"></script>
