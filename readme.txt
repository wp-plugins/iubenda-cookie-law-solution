=== Plugin Name ===
Contributors: iubenda
Donate link:
Tags: cookies, cookie law, cookie policy, cookie banner, cookie block, privacy policy, cookie consent
Requires at least: 3.0.1
Tested up to: 4.4.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin that works with the iubenda Cookie Law Solution that shows a cookie banner & allows blocking prior to consent, particularly fit for Italy.

== Description ==

NOTE: This plugin is a very early beta and could lead to problems. We encourage you to actively let us know about the problems here: http://gsfn.us/t/4qpks

This plugin works with the Iubenda Cookie Law Solution and allows to block the most common widgets and third party cookies to comply with Cookie Laws, particularly with the Italian implementation in mind.

* The plugin automatically inserts the Iubenda code in the head of every page of the site
* It automatically blocks scripts by YouTube, Facebook, G + and Twitter (other automatic blocks on the way!)
* It allows to manually block all the remaining resources, without the need of direct intervention on the code
* It handles the display of cookie banners and cookie policy, saving user preferences about the use of cookies

Under "Installation/Other Notes" you will find instructions in both English and Italian.

== Installation ==

**NOTE: This plugin is a very early beta and could lead to problems.** We encourage you to actively let us know about the problems here: http://gsfn.us/t/4qpks

- **Installation via WP.org**: search in your WordPress plugin admin panel for "Iubenda Cookie Solution", install it;
- Once the plugin is installed and activated, go to the Admin Panel (Settings > Iubenda Cookie Solution) where you will be asked to paste the code into tht field that gets generated from your Iubenda account dashboard when you activate the cookie law kit for your privacy policy. For more information on how to activate the cookie law kit, see this article: https://www.iubenda.com/it/help/posts/680;
- At this point the plugin will begin to show the banner on which displays your cookie policy (link) to users who visit the site for the first time. No need for other configurations;
- Furthermore, the plugin automatically recognizes and blocks cookies that get installed via the YouTube video player and social widgets - such as the Facebook Like Box - on your site. **Important note** the scripts for Facebook, Twitter, G+, and YouTube iframe only get blocked automatically when generated from the server side (therefore processed by PHP via WordPress). Scripts that are added to the page via Javascript after page load cannot be blocked automatically;
- The other scripts that install cookies for which the automatic block isn't yet available can and should be "wrapped" using these comments:

      `<!--IUB_COOKIE_POLICY_START-->
      <!--IUB_COOKIE_POLICY_END-->`

- **Installazione automatica**: installa da WordPres.org cercando "Iubenda Cookie Solution";
- Una volta installato ed attivato il plugin, accedi al pannello Admin (Impostazioni > Iubenda Cookie Solution) dove ti verrà chiesto di incollare in un campo il codice che iubenda genera quando attivi il kit cookie law sulla tua privacy policy. Per ulteriori informazioni su come attivare il kit cookie law, consulta questo articolo: https://www.iubenda.com/it/help/posts/680;
- A questo punto il plugin inizierà a mostrare il banner in cui è richiamata la tua cookie policy agli utenti che visitano il sito per la prima volta senza la necessità di altre configurazioni;
- In più, il plugin riconoscerà e bloccherà in automatico i cookie installati da tutti i video player di YouTube e dai widget sociali – come il Facebook Like Box – presenti sul tuo sito. **Nota importante**: il nostro plugin wordpress blocca in modo automatico tutti gli script Facebook, Twitter, G+, iframe youtube che sono generati lato server (quindi restituiti via PHP da wordpress). Script che vengono inseriti nella pagina dopo il loading della pagina tramite Javascript non sono e non possono essere bloccati in modo automatico;
- Gli altri script per i quali non è ancora disponibile il blocco automatico – e che installano cookie che richiedono il blocco prima del consenso – vanno “avvolti” utilizzando questi commenti:

      `<!--IUB_COOKIE_POLICY_START-->
      <!--IUB_COOKIE_POLICY_END-->`

== Screenshots ==

1. This screen shot shows the default banner on top of our test site testkada4.altervista.org/cookie-test/example2.html
2. When clicking on the cookie policy link, the user gets a view of the entire cookie policy, where they ultimately can give their consent

== Changelog ==

= 1.9.19 =
* new iframe src according to the new doc

= 1.9.18 =
* bug on all iframe, suppressedsrc is not null anymore

= 1.9.17 =
* added another url of google maps embed

= 1.9.16 =
* skip parsing page if bot/crawler + added checkbox to autoparse (or not) the page if the user have already given the consent

= 1.9.15 =
* include bug + google maps

= 1.9.14 =
* Autoconvert iframe vimeo + facebook likebox 

= 1.9.13 =
* Now the plugin use iubenda.class.php + fix bug on it.

= 1.9.12 =
* Add iub__no_parse get parameter to skip parsing page

= 1.9.11 =
* Add iub__no_parse get parameter to skip parsing page

= 1.9.10 =
* Another adsense script blocked, another fix on simple html dom

= 1.9.9 =
* Bugs page 60000 chars 

= 1.9.8 =
* Added Google Maps & Google Adsense + better shortcode handling

= 1.9.7 =
* minor bugfix

= 1.9.6 =
* bugfix: custom banner now allowed

= 1.9.5 =
* no refresh page needed to activate scripts inside IUB tags.

= 1.9.4 =
* wp-admin blank page bug fix

= 1.9.3 =
* G+ platform bug, typo: _iub_cs_activate_inline vs _iub_cs_activate-inline

= 1.9.2 =
* G+ platform bug

= 1.9.1 =
* Minor improvements

= 1.9 =
* Improved parsing without regex
* No parsing if the user have already given the consent

= 1.0 =
* First plugin version.

== Usage ==

How does this plugin work with a Facebook button, for example?

    <!--IUB_COOKIE_POLICY_START-->
    <script>
    (function(d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&#038;version=v2.3&#038;appId=808061959224601";
     fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <!--IUB_COOKIE_POLICY_END-->

If there are HTML / IMG / IFRAME elements, you need to proceed in this way:

    <!--IUB_COOKIE_POLICY_START-->
          <iframe src="...
          <img src="...
    <!--IUB_COOKIE_POLICY_END-->

For articles, however, there's a shortcode available:

    [iub-cookie-policy]
    [/iub-cookie-policy]

In case of continued browsing, the preferences of your users for the use of cookies will be set on "OK" to clear the banner and unlock the cookies. Moreover, banners and the blocking codes will not be delivered to subsequent visits by users who have already given their consent (and such preference will be updated at each subsequent visit for the future).

== Further notes ==

At the moment the automatic blocking of the YouTube video player and social widgets are done only if these scripts are located after the function wp_head(). The solution is the first version. Test it and contact us to report any errors.

Header image for this plugin page [graciously provided by this person](http://www.sketchappsources.com/free-source/1012-minimal-lines-device-icons-sketch-freebie-resource.html).

== Bug reports ==

* The best way you can help us is by providing as much information as possible, including the use of wp_debug https://codex.wordpress.org/Debugging_in_WordPress.
* We will be very happy to receive feedback here: http://gsfn.us/t/4qpks

== Istruzioni in italiano ==

Per esempio in un plugin Facebook dovrai fare come segue:

    <!--IUB_COOKIE_POLICY_START-->
    <script>
    (function(d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&#038;version=v2.3&#038;appId=808061959224601";
     fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <!--IUB_COOKIE_POLICY_END-—>

Se invece ci sono parti di HTML / IMG / IFRAME, bisogna procedere in questo modo:

    <!--IUB_COOKIE_POLICY_START-->
          <iframe src="...
          <img src="...
    <!--IUB_COOKIE_POLICY_END-->

Per gli articoli, invece, è disponibile uno shortcode:

    [iub-cookie-policy]
    [/iub-cookie-policy]

In caso di proseguimento della navigazione, le preferenze dei tuoi utenti circa l’installazione dei cookie verranno settate sul si in modo da far scomparire il banner e da sbloccare i cookie. Inoltre, banner e blocco codici non verranno erogati alle successive visite da parte degli utenti che hanno già prestato il proprio consenso (e tale preferenza verrà aggiornata ad ogni successiva visita).

== Note ulteriori ==

Al momento il blocco automatico dei video player di YouTube e dei widget sociali avviene solo se questi script si trovano dopo la funzione wp_head(). La soluzione è alla prima versione. Testatela e contattateci per segnalare eventuali errori.

== Segnalazioni di bug ==

* Il modo migliore per aiutarci è quello di fornire quante più informazioni possibili, compreso l'uso di wp_debug https://codex.wordpress.org/Debugging_in_WordPress.
* Saremo molto contenti di ricevere feedback qui: http://gsfn.us/t/4qpks
