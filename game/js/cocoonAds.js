var ads = {interstitialAlreadyDownloaded: !1, bannerAlreadyDownloaded: !1};
Cocoon.Ad.banner.on("shown", function () {
    ads.bannerAlreadyDownloaded = !1;
    console.log("Banner shown!");
    Cocoon.Ad.loadBanner()
});
Cocoon.Ad.banner.on("ready", function () {
    Cocoon.Ad.setBannerLayout(Cocoon.Ad.BannerLayout.BOTTOM_CENTER);
    console.log("Banner ready");
    ads.bannerAlreadyDownloaded = !0
});
Cocoon.Ad.banner.on("hidden", function () {
    console.log("Banner hidden!")
});
Cocoon.Ad.interstitial.on("shown", function () {
    ads.interstitialAlreadyDownloaded = !1;
    Cocoon.Ad.loadInterstitial();
    console.log("Interstitial shown!")
});
Cocoon.Ad.interstitial.on("ready", function () {
    ads.interstitialAlreadyDownloaded = !0;
    console.log("Interstitial ready")
});
Cocoon.Ad.interstitial.on("hidden", function () {
    console.log("Interstitial hidden!")
});
Cocoon.Ad.loadBanner();
Cocoon.Ad.loadInterstitial();
