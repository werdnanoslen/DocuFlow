var PasswordStrength = {
    watch: function (password_input_id) {
        var input = $(password_input_id);
        assert(input, "Password Strength input missing: " + password_input_id);

        var container = (new Element("div")).addClassName('password_strength_container');
        input.parentNode.appendChild(container);

        var bg_elm = (new Element("div")).addClassName('password_strength_bg');
        container.appendChild(bg_elm);

        var elm = new Element("div");
        elm = $(elm);
        elm.cur_score = 0;
        elm.addClassName("password_strength");
        container.appendChild(elm);

        for (var i = 1; i <= 3; i++) {
            var cls = {'class': 'password_strength_separator'};
            var style = {left: 25*i + '%'};
            container.appendChild((new Element('div', cls)).setStyle(style));
        }

        var advice = _("A good password is easy to remember but hard for a stranger to guess. Uncommon words work well, but only if you use several. Also helpful: non-standard uPPercasing, creative spelllling, personal neologisms, and non-obvious numbers and symbols (using $ for s or 0 for o is too obvious!)");
        var bubble_text = new Element("span", {'id': 'bubble_text'});

        var info_button = new Element('a', {href: '#', tabindex: '-1', 'class': 'password_strength_icon'});
        info_button.update(Sprite.make('web', 'information'));
        info_button.style.display = 'none';
        info_button.observe('mouseover', function () {Tooltip.show(info_button, bubble_text, false, "right", {'width': 300});});

        info_button.observe('click', function (e) {e.preventDefault();});
        container.appendChild(info_button);

        var password_desc = new Element('div', {'class': 'password_strength_desc'});
        password_desc.update('&nbsp;');
        container.appendChild(password_desc);

        var clearfix = new Element('div', {'class': 'clearfix'});

        container.appendChild(clearfix);

        var color_map = [
            "",
            "#c81818",
            "#ffac1d",
            "#a6c060",
            "#27b30f"
        ];

        var word_map = [
            // TRANSLATORS the following strings refer to a password strength meter on the registration page
            ["", _("Very weak")],
            ["#c81818", _("Weak")],
            ["#e28f00", _("So-so")],
            ["#8aa050", _("Good")],
            ["#27b30f", _("Great!")]
        ];

        var last_pwd = '';

        var animator = function () {
            var pwd = $F(input);
            if (pwd == last_pwd) {
                return;
            }
            last_pwd = pwd;

            var score, word;

            if (pwd == 'correcthorsebatterystaple' || pwd == 'Tr0ub4dour&3' || pwd == 'Tr0ub4dor&3') { // easteregg
                score = 0;
                word = ['', 'lol']
                if (pwd == 'correcthorsebatterystaple') {
                    // TRANSLATORS this text is displayed rarely, whenever a user selects a password that is from this comic:
                    // http://imgs.xkcd.com/comics/password_strength.png
                    bubble_text.update(_("Whoa there, don't take advice from a webcomic too literally ;)"))
                } else {
                    // TRANSLATORS this text is displayed rarely, whenever a user selects a password that is from this comic:
                    // http://imgs.xkcd.com/comics/password_strength.png
                    bubble_text.update(_("Guess again"))
                }
            } else {
                score = PasswordStrength.score(pwd);
                word = word_map[score];
                bubble_text.update(advice);
            }

            password_desc.style.color = word[0];
            password_desc.update(pwd.length ? word[1] : "&nbsp;");

            if (pwd.length && score < 3) {
                info_button.show();
            } else {
                info_button.hide();
                if (info_button.tooltip) {
                    info_button.tooltip.hide();
                }
            }

            var color_ind = score;
            elm.style.backgroundColor = color_map[color_ind];
            elm.cur_score = score;
            if (score == 0) {
                elm.style.width = "0%";
            }
            else {
                elm.style.width = (score * 25) + "%";
            }
        };

        setInterval(animator, 350);
    },
    get_user_inputs: function () {
        var inputs = 'dropbox'.split();
        fname = $('fname');
        lname = $('lname');
        email = $('email');
        if (fname) {
            inputs.push(fname.getValue());
        }
        if (lname) {
            inputs.push(lname.getValue());
        }
        if (email) {
            inputs.push(email.getValue());
        }
        return inputs;
    },
    score: function (str) {
        if (!window.zxcvbn) {
            return 0;
        }
        var result = zxcvbn(str, PasswordStrength.get_user_inputs());
        return result.score;
    }
};

// inline copy of /static/javascript/external/zxcvbn-async.js
// (with modified src to match metaserver's zxcvbn.js location.)
(function(){var a;a=function(){var a,b;b=document.createElement("script");b.src="/static/javascript/external/zxcvbn.js";b.type="text/javascript";b.async=!0;a=document.getElementsByTagName("script")[0];return a.parentNode.insertBefore(b,a)};null!=window.attachEvent?window.attachEvent("onload",a):window.addEventListener("load",a,!1)}).call(this);
