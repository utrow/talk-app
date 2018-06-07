ons.bootstrap()
    .controller('TabbarController', function($scope) {
        $scope.title = '友だち';
        $scope.updateTitle = function($event) {
            $scope.title = angular.element($event.tabItem).attr('label');
        };
    });
var user = null;
var token = '';
ons.ready(function() {
    myNavigator.on('prepush', function(e) {
        console.group('prepush');
        console.log(e.currentPage);
        console.log(e.navigator);
        console.groupEnd();
    });
    myNavigator.on('postpop', function(e) {
        console.group('postpop');
        console.log(e.currentPage);
        console.log(e.navigator);
        console.groupEnd();
    });
    $.getJSON('/auth/token', function(json) {
        token = json.token;

    });

    $.getJSON('/auth/loggedin', function(json) {
        if (json.code >= 0) {
            setTimeout(function() {
                myNavigator.resetToPage('home.html');
            }, 1000);
        } else {
            setTimeout(function() {
                myNavigator.resetToPage('auth.html', { animation: 'none' });
            }, 1000);
        }

    });



});


document.addEventListener('init', function(event) {
    var page = event.target;
    if (page.matches('#Tab1')) {
        friend_list();
    } else if (page.matches('#page2')) {
        console.log('page2');
        console.log(page.data.screenname);
        $('#page2 ons-toolbar .center').html(page.data.screenname);

    }

});

$(document).on('click', 'ons-list-item', function(e) {
    myNavigator.pushPage('page2.html', {
        data: {
            screenname: $(e.target).closest("ons-list-item").find(".username").text()
        }
    });
});
var friend_list = function() {
    $("#friends-list").text('');
    $.ajax({
        type: 'GET',
        url: '/friends/list',
        cache: false,
        xhrFields: {
            withCredentials: true
        },
        success: function(data, dataType) {
            data = $.parseJSON(data);
            $.each(data.friends, function(i, e) {
                $("#friends-list").loadTemplate(
                    "/dist/js/app/templates/friend.html", {
                        "name": e.username,
                        "icon": '/dist/icon.png',
                        "comment": 'user comment.'
                    }, {
                        append: true,
                        overwriteCache: true
                    });
            });

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            ons.notification.alert('通信に失敗しました。');
        }
    });


}

var login = function() {
    if ($('#login #username').val() === '' && $('#login #password').val() === '') {
        ons.notification.alert('ユーザID、または、パスワードが入力されていません。');
    } else {
        $.ajax({
            type: 'POST',
            url: '/auth/login',
            cache: false,
            xhrFields: {
                withCredentials: true
            },
            data: {
                'token': token,
                'username': $('#login #username').val(),
                'password': $('#login #password').val(),
            },
            success: function(data, dataType) {
                data = $.parseJSON(data);
                if (data.code > 0) {
                    user = data.user;
                    myNavigator.resetToPage('home.html');
                } else {
                    ons.notification.alert(data.text);
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                ons.notification.alert('通信に失敗しました。');
            }
        });
    }

};
var register = function() {
    if ($('#register #username').val() === '' && $('#register #password').val() === '') {
        ons.notification.alert('ユーザID、または、パスワードが入力されていません。');
    } else {
        $.ajax({
            type: 'POST',
            url: '/auth/register',
            cache: false,
            xhrFields: {
                withCredentials: true
            },
            data: {
                'token': token,
                'username': $('#register #username').val(),
                'password': $('#register #password').val(),
                'repassword': $('#register #repassword').val(),
            },
            success: function(data, dataType) {
                data = $.parseJSON(data);
                if (data.code > 0) {
                    user = data.user;
                    myNavigator.resetToPage('home.html');
                } else {
                    ons.notification.alert(data.text);
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                ons.notification.alert('通信に失敗しました。');
            }
        });
    }
};

var add_friend = function() {
    myNavigator.pushPage('add-friend.html');
};

var add_friend_send = function() {
    if ($('#friend-username').val() === '') {
        ons.notification.alert('ユーザIDが入力されていません。');
    } else {
        $.ajax({
            type: 'POST',
            url: '/friends/add',
            cache: false,
            xhrFields: {
                withCredentials: true
            },
            data: {
                'token': token,
                'username': $('#friend-username').val(),
            },
            success: function(data, dataType) {
                data = $.parseJSON(data);
                if (data.code > 0) {
                    myNavigator.popPage();
                    ons.notification.toast(data.user.username + 'さんを追加しました。', { timeout: 1000, animation: 'fall' });
                    friend_list();

                } else {
                    ons.notification.alert(data.text);
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                ons.notification.alert('通信に失敗しました。');
            }
        });
    }
};