class VillasMap {
  constructor(block) {
    this.Elements = {
      cards: document.querySelectorAll(".card-villa"),
      map: {
        container: block, // document.querySelector('#mapContainer')
        content: block.querySelector("#mapContent"),
      },
      btns: {
        zoomIn: block.querySelector("#btnZoomInMap"),
        zoomOut: block.querySelector("#btnZoomOutMap"),
        full: block.querySelector("#btnFullMap"),
      },
    };

    this.State = {
      isFullScreen: false,
      map: null,
      currentInfoWindow: null,
      currentActiveMarker: null,
    };

    this.init();
  }
  async init() {
    await this.map();
    this.Elements.btns.zoomIn.addEventListener("click", this.handleBtnZoomIn.bind(this));
    this.Elements.btns.zoomOut.addEventListener("click", this.handleBtnZoomOut.bind(this));
    this.Elements.btns.full.addEventListener("click", this.handleBtnFull.bind(this));
  }
  handleBtnZoomIn() {
    this.State.map.setZoom(this.State.map.getZoom() + 1);
  }
  handleBtnZoomOut() {
    this.State.map.setZoom(this.State.map.getZoom() - 1);
  }
  handleBtnFull() {
    if (this.State.isFullScreen) {
      this.State.isFullScreen = false;
      document.exitFullscreen();
      this.Elements.map.container.classList.remove("map-fullscreen");
    } else {
      this.State.isFullScreen = true;
      this.Elements.map.container.requestFullscreen();
      this.Elements.map.container.classList.add("map-fullscreen");
    }
  }
  async map() {
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerView } = await google.maps.importLibrary("marker");

    const bounds = new google.maps.LatLngBounds();
    const styles = new google.maps.StyledMapType(
      [
        {
          featureType: "poi",
          stylers: [
            {
              visibility: "off",
            },
          ],
        },
      ],
      {
        name: "Styled Map",
      }
    );

    this.State.map = new Map(this.Elements.map.content, {
      zoom: 4,
      center: { lat: -25.344, lng: 131.031 },
      mapId: "VILLASIA_MAP_ID",
      disableDefaultUI: true,
    });

    this.Elements.cards.forEach((card) => {
      const villaData = {
        position: {
          lat: card.getAttribute("data-map-lat") ? Number(card.getAttribute("data-map-lat")) : "",
          lng: card.getAttribute("data-map-lng") ? Number(card.getAttribute("data-map-lng")) : "",
        },
        price: card.querySelector(".card-villa__footer-top__title-price")?.textContent,
        image: card.querySelector(".card-villa__swiper-slide img")?.getAttribute("src"),
        title: card.querySelector(".card-villa__header-top__title")?.textContent,
        rating: card.querySelector(".card-villa__header-top__rate")?.textContent,
        guests: card.querySelector(".card-villa__header-bottom__guests")?.textContent,
        bedrooms: card.querySelector(".card-villa__header-bottom__bedrooms")?.textContent,
      };

      if (villaData.position.lat && villaData.position.lng) {
        bounds.extend(villaData.position);

        const marker = new AdvancedMarkerView({
          map: this.State.map,
          position: villaData.position,
          content: createElementMarker(villaData.price),
        });

        const infowindow = new google.maps.InfoWindow({
          content: createHtmlInfoWindow(
            villaData.image,
            villaData.title,
            villaData.rating,
            villaData.guests,
            villaData.bedrooms
          ),
          ariaLabel: villaData.title,
        });

        marker.addListener("click", (e) => {

          if (this.State.currentInfoWindow) {
            this.State.currentInfoWindow.close();
          }

          if (this.State.currentActiveMarker) {
            this.State.currentActiveMarker.classList.remove("active");
          }
          
          const currentMarker = e.domEvent.target;

          infowindow.open({
            anchor: marker,
            map: this.State.map,
          });

          currentMarker.classList.add("active");

          this.State.currentActiveMarker = currentMarker;
          this.State.currentInfoWindow = infowindow;
        });
      }
    });

    this.State.map.mapTypes.set("styled_map", styles);
    this.State.map.setMapTypeId("styled_map");
    this.State.map.fitBounds(bounds);

    function createHtmlInfoWindow(image, title, rating, guests, bedrooms) {
      return `
        <div class="villas-map__window">
          <div class="villas-map__window__image">
            <img src="${image}" alt="" />
          </div>
          <div class="villas-map__window__content">
            <div class="villas-map__window__header">
              <h2 class="villas-map__window__header-title">${title}</h2>
              ${
                rating
                  ? `<span class="villas-map__window__header-rating ct-icon ct-icon--fill-star" data-icon-pos="left">${rating}</span>`
                  : ""
              }
            </div>
            <div class="villas-map__window__info">
              <span class="villas-map__window__info-item ct-icon ct-icon--fill-person" data-icon-pos="left">${guests}</span>
              <span class="villas-map__window__info-item ct-icon ct-icon--fill-bed" data-icon-pos="left">${bedrooms}</span>
            </div>
          </div>
        </div>
      `;
    }
    function createElementMarker(price) {
      const elem = document.createElement("div");
      elem.className = "villas-map__marker";
      elem.textContent = price;

      return elem;
    }
  }
}

export default () => {
  const block = document.querySelector(".villas-map");
  if (block) new VillasMap(block);
};
