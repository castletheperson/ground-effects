# Ground Effects Landscaping

Accessible at: https://nwageffects.com/

### Installation:

    git clone https://github.com/castletheperson/ground-effects.git
    npm install

### Useful commands:

    gulp
    firebase serve
    firebase deploy

### Files of high interest:

    gulpfile.ts
    firebase.json
    public/
    src/
    functions/src/
    functions/views/

### Configuration required:

Get a site key and secret key from https://www.google.com/recaptcha/ with a URL for wherever you plan to host the site (localhost?)

    firebase functions:config:set recaptchav3.sitekey=SITE_KEY recaptchav3.secretkey=SECRET_KEY
