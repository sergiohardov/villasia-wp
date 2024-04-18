"use strict";

/* Base */
import * as Base from "./_base.js";

/* Components */
// Site
import siteHeader from "./components/site/header.js";
import siteMenu from "./components/site/menu.js";
import sitePopular from "./components/site/popular.js";

// Home
import homeHero from "./components/home/hero.js";
import homePromotions from "./components/home/promotions.js";
import homeBlog from "./components/home/blog.js";
import homeInstagram from "./components/home/instagram.js";

// Villa
import villaGallery from "./components/villa/gallery.js";
import villaNavigation from "./components/villa/navigation.js";
import villaBedrooms from "./components/villa/bedrooms.js";
import villaRates from "./components/villa/rates.js";
import villaLocation from "./components/villa/location.js";
import villaRelated from "./components/villa/related.js";
import villaReviews from "./components/villa/reviews.js";

// Card
import cardVilla from "./components/card/villa.js";
import cardBooking from "./components/card/booking.js";

// Interface
import interfaceCounter from "./components/interface/counter.js";
import interfaceDestination from "./components/interface/destination.js";
import interfaceCheck from "./components/interface/check.js";
import interfaceBedroom from "./components/interface/bedroom.js";
import interfaceGuests from "./components/interface/guests.js";
import interfaceRange from "./components/interface/range.js";

// Other
import searchBar from "./components/search/bar.js";
import sliderLocations from "./components/slider-locations.js";
import villasMap from "./components/villas-map.js";

/* Pages */
import pageBlog from "./page/blog.js";
import pageContact from "./page/contact.js";
import pageSubmit from "./page/submit.js";
import pageGeneral from "./page/general.js";
import pageWishlist from "./page/wishlist.js";
import pageInquiry from "./page/inquiry.js";
import pageVilla from "./page/villa.js";
import pageManagment from "./page/managment.js";

// Before init
Base.googleMaps();

document.addEventListener("DOMContentLoaded", () => {
  /* Base */
  Base.headerHeight();
  Base.dropdown();
  Base.tabs();

  /* Components */
  // Site
  siteHeader();
  siteMenu();
  sitePopular();

  // Home
  homeHero();
  homePromotions();
  homeBlog();
  homeInstagram();

  // Villa
  villaGallery();
  villaNavigation();
  villaBedrooms();
  villaRates();
  villaLocation();
  villaRelated();
  villaReviews();

  // Card
  cardVilla();
  cardBooking();

  // Interface
  interfaceCounter();
  interfaceDestination();
  interfaceCheck();
  interfaceBedroom();
  interfaceGuests();
  interfaceRange();

  // Other
  searchBar();
  sliderLocations();
  villasMap();

  /* Pages */
  pageBlog();
  pageContact();
  pageSubmit();
  pageGeneral();
  pageWishlist();
  pageInquiry();
  pageVilla();
  pageManagment();
});
