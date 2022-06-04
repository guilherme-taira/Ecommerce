<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        jdgm = window.jdgm || {};
        jdgm.SHOP_DOMAIN = 'maximo-produto.myshopify.com';
        jdgm.PLATFORM = 'shopify';
        jdgm.PUBLIC_TOKEN = 'ZYXIG9HFh1_PBmSEOVgOESP2iRU';
    </script>
    <script data-cfasync='false' type='text/javascript' async src='https://cdn.judge.me/widget_preloader.js'></script>
    <script data-cfasync='false' type='text/javascript' async src='https://cdn.judge.me/assets/installed.js'></script>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        if (!customElements.get('media-gallery')) {
  customElements.define('media-gallery', class MediaGallery extends HTMLElement {
    constructor() {
      super();
      this.elements = {
        liveRegion: this.querySelector('[id^="GalleryStatus"]'),
        viewer: this.querySelector('[id^="GalleryViewer"]'),
        thumbnails: this.querySelector('[id^="GalleryThumbnails"]')
      }
      this.mql = window.matchMedia('(min-width: 750px)');
      if (!this.elements.thumbnails) return;

      this.elements.viewer.addEventListener('slideChanged', debounce(this.onSlideChanged.bind(this), 500));
      this.elements.thumbnails.querySelectorAll('[data-target]').forEach((mediaToSwitch) => {
        mediaToSwitch.querySelector('button').addEventListener('click', this.setActiveMedia.bind(this, mediaToSwitch.dataset.target, false));
      });
      if (this.dataset.desktopLayout !== 'stacked' && this.mql.matches) this.removeListSemantic();
    }

    onSlideChanged(event) {
      const thumbnail = this.elements.thumbnails.querySelector(`[data-target="${ event.detail.currentElement.dataset.mediaId }"]`);
      this.setActiveThumbnail(thumbnail);
    }

    setActiveMedia(mediaId, prepend) {
      const activeMedia = this.elements.viewer.querySelector(`[data-media-id="${ mediaId }"]`);
      this.elements.viewer.querySelectorAll('[data-media-id]').forEach((element) => {
        element.classList.remove('is-active');
      });
      activeMedia.classList.add('is-active');

      if (prepend) {
        activeMedia.parentElement.prepend(activeMedia);
        if (this.elements.thumbnails) {
          const activeThumbnail = this.elements.thumbnails.querySelector(`[data-target="${ mediaId }"]`);
          activeThumbnail.parentElement.prepend(activeThumbnail);
        }
        if (this.elements.viewer.slider) this.elements.viewer.resetPages();
      }

      this.preventStickyHeader();
      window.setTimeout(() => {
        if (this.elements.thumbnails) {
          activeMedia.parentElement.scrollTo({ left: activeMedia.offsetLeft });
        }
        if (!this.elements.thumbnails || this.dataset.desktopLayout === 'stacked') {
          activeMedia.scrollIntoView({behavior: 'smooth'});
        }
      });
      this.playActiveMedia(activeMedia);

      if (!this.elements.thumbnails) return;
      const activeThumbnail = this.elements.thumbnails.querySelector(`[data-target="${ mediaId }"]`);
      this.setActiveThumbnail(activeThumbnail);
      this.announceLiveRegion(activeMedia, activeThumbnail.dataset.mediaPosition);
    }

    setActiveThumbnail(thumbnail) {
      if (!this.elements.thumbnails || !thumbnail) return;

      this.elements.thumbnails.querySelectorAll('button').forEach((element) => element.removeAttribute('aria-current'));
      thumbnail.querySelector('button').setAttribute('aria-current', true);
      if (this.elements.thumbnails.isSlideVisible(thumbnail, 10)) return;

      this.elements.thumbnails.slider.scrollTo({ left: thumbnail.offsetLeft });
    }

    announceLiveRegion(activeItem, position) {
      const image = activeItem.querySelector('.product__modal-opener--image img');
      if (!image) return;
      image.onload = () => {
        this.elements.liveRegion.setAttribute('aria-hidden', false);
        this.elements.liveRegion.innerHTML = window.accessibilityStrings.imageAvailable.replace(
          '[index]',
          position
        );
        setTimeout(() => {
          this.elements.liveRegion.setAttribute('aria-hidden', true);
        }, 2000);
      };
      image.src = image.src;
    }

    playActiveMedia(activeItem) {
      window.pauseAllMedia();
      const deferredMedia = activeItem.querySelector('.deferred-media');
      if (deferredMedia) deferredMedia.loadContent(false);
    }

    preventStickyHeader() {
      this.stickyHeader = this.stickyHeader || document.querySelector('sticky-header');
      if (!this.stickyHeader) return;
      this.stickyHeader.dispatchEvent(new Event('preventHeaderReveal'));
    }

    removeListSemantic() {
      if (!this.elements.viewer.slider) return;
      this.elements.viewer.slider.setAttribute('role', 'presentation');
      this.elements.viewer.sliderItems.forEach(slide => slide.setAttribute('role', 'presentation'));
    }
  });
}



    </script>

</head>

<body>
    <?php

    // 
    // $_SESSION['pages'] = isset($_REQUEST['pages']) ? intval($_REQUEST['pages']) : $_REQUEST['pages'] = 1;
    
    // $pagina = intval($_SESSION['pages']);

    include_once 'JudmeProductRewier.php';
    $judme = new Reviews('ZYXIG9HFh1_PBmSEOVgOESP2iRU', 'maximo-produto.myshopify.com', 316393458, 1, 3);
    $html = $judme->resource();
    echo "<div class='jdgm-verified-badge-wrapper'></div>";
    echo "<div> $html </div>";

    // echo "<a href='teste.php?pages=".avancar($_SESSION['pages'])."'>Avançar</a> / <a href='teste.php?pages=".voltar($_SESSION['pages'])."'>Voltar</a> ";

    // function avancar($page){
    //     $page += 1;
    //     return $page;
    // }

    // function voltar($page){
    //     $page -= 1;
    //     return $page;
    // }

    ?>
</body>

</html>


35220100458459000133550030001250561560460230,
35220100458459000133550030001249631145102266,
35220100458459000133550030001250491629938601

3541943