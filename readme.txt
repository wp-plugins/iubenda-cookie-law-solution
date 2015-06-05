=== Plugin Name ===
Contributors: iubenda
Donate link: 
Tags: cookies, cookie law, cookie policy, cookie banner, cookie block, privacy policy, cookie consent
Requires at least: 3.0.1
Tested up to: 4.4.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Iubenda cookie solution plugin for WordPress for the creation of cookie banners and consent based cookie blocks. The plugin works with the Iubenda Cookie Law Solution and allows WordPress users to block the most common widgets to comply with the Cookie Law, particularly designed for Italy.

== Description ==

This plugin is described in English, browse down to the end of the readme to find an Italian version.

# Functionality

- The plugin automatically inserts the Iubenda code in the head of every page of the site
- It automatically blocks scripts by YouTube, Facebook, G + and Twitter (other automatic blocks on the way!)
- It allows to manually block all the remaining resources, without the need of direct intervention on the code
- It handles the display of cookie banners and cookie policy, saving user preferences about the use of cookies

== Installation ==

- **Manual installation**: download the plugin, go to the WordPress admin panel of your site and click on Plugins > Add New. At the top, then click the "upload plugin" button and then choose the ZIP file from your computer you just downloaded. Finally, click on "Install Now" and activate the plugin;
- **Installation via WP.org**: search in your WordPress plugin admin panel for "Iubenda Cookie Law Solution for Wordpress", install it;
- Once the plugin is installed and activated, go to the Admin Panel (Settings > Iubenda Cookie Solution) where you will be asked to paste the code into tht field that gets generated from your Iubenda account dashboard when you activate the cookie law kit for your privacy policy. For more information on how to activate the cookie law kit, see this article: https://www.iubenda.com/it/help/posts/680
- At this point the plugin will begin to show the banner on which displays your cookie policy (link) to users who visit the site for the first time. No need for other configurations.
- Furthermore, the plugin automatically recognizes and blocks cookies that get installed via the YouTube video player and social widgets - such as the Facebook Like Box - on your site.
- The other scripts that install cookies for which the automatic block isn't yet available can and should be "wrapped" using these comments:

      `<!--IUB_COOKIE_POLICY_START-->
      <!--IUB_COOKIE_POLICY_END-->`

== Changelog ==

= 1.9.3 =
* G+ platform bug, typo: _iub_cs_activate_inline vs _iub_cs_activate-inline

= 1.9.2 =
* G+ platform bug

= 1.9.1 =
* Minor improvements 

= 1.9 =
* Improved parsing without regex
* No parsing if the user has already given the consent

= 1.0 =
* First plugin version.

== Usage ==

How does this plugin work with a Facebook button for example?

    `<!--IUB_COOKIE_POLICY_START-->
    <script>
    (function(d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&#038;version=v2.3&#038;appId=808061959224601";
     fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <!--IUB_COOKIE_POLICY_END-->`

If there are HTML / IMG / IFRAME elements, you need to proceed in this way:

    `<!--IUB_COOKIE_POLICY_START-->
          <iframe src="...
          <img src="...
    <!--IUB_COOKIE_POLICY_END-->`

For articles, however, there's a shortcode available:

    `[iub-cookie-policy]
    [/iub-cookie-policy]`

In case of continued browsing, the preferences of your users for the use of cookies will be set on "OK" to clear the banner and unlock the cookies. Moreover, banners and the blocking codes will not be delivered to subsequent visits by users who have already given their consent (and such preference will be updated at each subsequent visit for the future).

== Further notes ==

At the moment the automatic blocking of the YouTube video player and social widgets are done only if these scripts are located after the function wp_head(). The solution is the first version. Test it and contact us to report any errors.

== Italian explanations ==

- Il plugin inserisce in modo automatico il codice di iubenda nell’head di tutte le pagine del sito
- Blocca in automatico i codici di YouTube, Facebook, G+ e Twitter (altri blocchi automatici in arrivo!)
- Permette di bloccare manualmente tutte le risorse restanti, senza la necessità di interventi diretti sul codice
- Gestisce la visualizzazione del banner e della cookie policy, ed il salvataggio delle preferenze degli utenti circa l’installazione dei cookie

# Istruzioni

- **Installazione manuale**: Scarica il plugin, accedi al pannello di amministrazione WordPress del tuo sito e clicca su Plugin > Aggiungi nuovo. In alto, clicca quindi sul pulsante Carica plugin e poi scegli dal tuo computer il file ZIP appena scaricato. Clicca infine su Installa adesso e attiva il plugin.
- **Installazione automatica**: installa dal repository WordPres.org cercando "Iubenda Cookie Law Solution for Wordpress"
- Una volta installato ed attivato il plugin, accedi al pannello Admin (Impostazioni > Iubenda Cookie Solution) dove ti verrà chiesto di incollare in un campo il codice che iubenda genera quando attivi il kit cookie law sulla tua privacy policy. Per ulteriori informazioni su come attivare il kit cookie law, consulta questo articolo: https://www.iubenda.com/it/help/posts/680
- A questo punto il plugin inizierà a mostrare il banner in cui è richiamata la tua cookie policy agli utenti che visitano il sito per la prima volta senza la necessità di altre configurazioni.
- In più, il plugin riconoscerà e bloccherà in automatico i cookie installati da tutti i video player di YouTube e dai widget sociali – come il Facebook Like Box – presenti sul tuo sito.
- Gli altri script per i quali non è ancora disponibile il blocco automatico – e che installano cookie che richiedono il blocco prima del consenso – vanno “avvolti” utilizzando questi commenti:

      `<!--IUB_COOKIE_POLICY_START-->
      <!--IUB_COOKIE_POLICY_END-->`

Per esempio in un plugin Facebook dovrai fare come segue:

    `<!--IUB_COOKIE_POLICY_START-->
    <script>
    (function(d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&#038;version=v2.3&#038;appId=808061959224601";
     fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <!--IUB_COOKIE_POLICY_END-—>`

Se invece ci sono parti di HTML / IMG / IFRAME, bisogna procedere in questo modo:

    `<!--IUB_COOKIE_POLICY_START-->
          <iframe src="...
          <img src="...
    <!--IUB_COOKIE_POLICY_END-->`


Per gli articoli, invece, è disponibile uno shortcode:

    `[iub-cookie-policy]
    [/iub-cookie-policy]`


In caso di proseguimento della navigazione, le preferenze dei tuoi utenti circa l’installazione dei cookie verranno settate sul si in modo da far scomparire il banner e da sbloccare i cookie. Inoltre, banner e blocco codici non verranno erogati alle successive visite da parte degli utenti che hanno già prestato il proprio consenso (e tale preferenza verrà aggiornata ad ogni successiva visita).

**Note ulteriori:**

Al momento il blocco automatico dei video player di YouTube e dei widget sociali avviene solo se questi script si trovano dopo la funzione wp_head(). La soluzione è alla prima versione. Testatela e contattateci per segnalare eventuali errori.
