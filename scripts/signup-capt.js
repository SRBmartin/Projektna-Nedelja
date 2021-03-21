var logCpt;
var signCpt;
var g_recapFunc = function(){
    logCpt = grecaptcha.render('g-rec-log',{
        'sitekey' : '6LfpjHgaAAAAAOMR8ghLBFYjRQYn9iNJIdNlavnP',
        'theme' : 'light'
    });
    signCpt = grecaptcha.render('signRecap',{
        'sitekey' : '6LfpjHgaAAAAAOMR8ghLBFYjRQYn9iNJIdNlavnP',
        'theme' : 'light'
    });
} 