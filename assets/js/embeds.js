(function () {
  /**
   * Normalize a numeric height from an attribute or a default value.
   * Adds “px” when a plain number is provided.
   */
  function normalizeHeight(value) {
    if (!value) {
      return '';
    }

    var trimmed = value.trim();
    if (!trimmed) {
      return '';
    }

    if (/^\d+$/.test(trimmed)) {
      return trimmed + 'px';
    }

    return trimmed;
  }

  function handleVideoEmbed(iframe) {
    var wrapper = iframe.closest('.wp-block-embed__wrapper');
    var existingResponsive = iframe.closest('.responsive-embed');

    if (wrapper) {
      wrapper.classList.add('embed--video');
      return;
    }

    if (existingResponsive) {
      existingResponsive.classList.add('embed--video');
      return;
    }

    var generated = document.createElement('div');
    generated.className = 'responsive-embed embed--video';
    iframe.parentNode.insertBefore(generated, iframe);
    generated.appendChild(iframe);
  }

  function handleSpotifyEmbed(iframe, src) {
    iframe.classList.add('embed--spotify');
    iframe.style.width = '100%';

    var wrapper = iframe.closest('.wp-block-embed__wrapper');
    var attrHeight = iframe.getAttribute('height');
    var normalizedHeight = normalizeHeight(attrHeight);
    var finalHeight;

    if (normalizedHeight) {
      finalHeight = normalizedHeight;
    } else if (attrHeight) {
      finalHeight = attrHeight;
    } else {
      finalHeight = (src.indexOf('/track/') > -1 ? 152 : 352) + 'px';
    }

    iframe.style.height = finalHeight;
    iframe.style.minHeight = finalHeight;

    var numericMatch = finalHeight.match(/^\d+/);
    if (numericMatch) {
      iframe.setAttribute('height', numericMatch[0]);
    }

    if (wrapper) {
      wrapper.style.height = finalHeight;
      wrapper.style.minHeight = finalHeight;
      wrapper.style.paddingTop = '0';
      wrapper.style.position = 'static';
      wrapper.style.aspectRatio = 'auto';
      wrapper.style.width = '100%';
      wrapper.style.overflow = 'visible';
    }

    var figure = iframe.closest('.wp-block-embed');
    if (figure) {
      figure.classList.add('embed--spotify');
      figure.classList.remove('wp-has-aspect-ratio', 'wp-embed-aspect-ratio-21-9', 'wp-embed-aspect-ratio-16-9');
      figure.style.minHeight = finalHeight;
      figure.style.height = finalHeight;
    }
  }

  function identifyAndFixEmbeds(root) {
    var iframes = root.querySelectorAll('iframe');

    iframes.forEach(function (iframe) {
      if (!iframe.src) {
        return;
      }

      var src = iframe.src;
      if (/youtube\.com\/embed|youtu\.be|youtube-nocookie\.com/.test(src) || /player\.vimeo\.com/.test(src)) {
        handleVideoEmbed(iframe);
      }

      if (/open\.spotify\.com\/embed/.test(src)) {
        handleSpotifyEmbed(iframe, src);
      }
    });
  }

  function initEmbeds() {
    var content = document.querySelector('.entry-content');
    if (!content) {
      return;
    }

    identifyAndFixEmbeds(content);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initEmbeds);
  } else {
    initEmbeds();
  }
})();
