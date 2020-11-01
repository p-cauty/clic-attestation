const localStorageKey = 'cookieChoice';
const cookiesChoice = localStorage.getItem(localStorageKey);

const loadAnalytics = () => {
    const generate_route = WEBROOT + 'generate';
    let path = window.location.pathname;
    if (path.indexOf(generate_route + '/') === 0) {
        path = WEBROOT + 'generate';
    }

    const matomo = 'var _paq = window._paq || [];' +
        '_paq.push([\'trackPageView\']);' +
        '_paq.push([\'enableLinkTracking\']);' +
        '(function() {' +
        '    var u="https://analytics.justauth.me/";' +
        '    _paq.push([\'setTrackerUrl\', u+\'matomo.php\']);' +
        '    _paq.push([\'setSiteId\', \'3\']);' +
        '    _paq.push([\'setCustomUrl\', \'' + path + '\']);' +
        '    var d=document, g=d.createElement(\'script\'), s=d.getElementsByTagName(\'script\')[0];' +
        '    g.type=\'text/javascript\'; g.async=true; g.defer=true; g.src=u+\'matomo.js\'; s.parentNode.insertBefore(g,s);' +
        '})();';

    const script = document.createElement('script');
    script.type = 'text/javascript';
    try {
        script.appendChild(document.createTextNode(matomo));
        document.body.appendChild(script);
    } catch (e) {
        script.text = matomo;
        document.body.appendChild(script);
    }
}

const setCookiesChoice = choice => {
    if (choice) {
        loadAnalytics();
    }

    localStorage.setItem(localStorageKey, choice ? 'ok' : 'ko');
    document.getElementById('cookies_prompt').style.display = 'none';
}

if (cookiesChoice === 'ok' || cookiesChoice === 'ko') {
    document.getElementById('cookies_prompt').style.display = 'none';
}

if (cookiesChoice === 'ok') {
    loadAnalytics();
}
