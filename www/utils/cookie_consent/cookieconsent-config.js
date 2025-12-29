const jsonPath = {};
if (language === 'cs') {
    jsonPath[language]  = {
        "consentModal": {
            "title": "Nastavení soukromí",
            "description": "Naše webové stránky používají pouze technicky nezbytné cookies, které jsou nutné pro bezchybný provoz stránky. Žádné další cookies pro sledování nebo marketing nejsou používány.",
            "acceptAllBtn": "Přijmout vše",
            "acceptNecessaryBtn": "Odmítnout vše"
        }
    }
} else {
    jsonPath[language] =  {
        "consentModal": {
            "title": "Privacy Settings",
            "description": "Our website only uses technically necessary cookies that are required for the proper functioning of the site. No additional cookies for tracking or marketing are used.",
            "acceptAllBtn": "Accept all",
            "acceptNecessaryBtn": "Reject all"
        }
    }
}

CookieConsent.run({
    disablePageInteraction: true,
    guiOptions: {
        consentModal: {
            layout: "bar",
            position: "bottom",
            equalWeightButtons: true,
            flipButtons: false
        }
    },
    categories: {
        necessary: {
            readOnly: true
        }
    },
    language: {
       default: language,
       translations: jsonPath
    },
    cookie: {
        expiresAfterDays: 365
    }
});