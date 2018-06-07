<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta http-equiv="Cache-Control" content="no-cache">
        <link rel="stylesheet" href="/dist/css/onsenui.css">
        <link rel="stylesheet" href="/dist/css/onsen-css-components.min.css">
        <script src="/dist/js/onsenui.min.js"></script>
        <script src="/dist/js/angular.min.js"></script>
        <script src="/dist/js/angular-onsenui.min.js"></script>
        <script src="/dist/js/jquery-3.3.1.min.js"></script>
        <script src="/dist/js/jquery.loadTemplate.min.js"></script>


    </head>

    <body>
        <ons-navigator swipeable var="myNavigator" page="splash.html"></ons-navigator>
        <!-- splash -->
        <template id="splash.html">
			<ons-page>
				<ons-progress-bar indeterminate></ons-progress-bar>
				<p style="text-align: center">
					ログイン情報を確認しています…
				  </p>
			</ons-page>
		</template>


        <!-- Login -->
        <template id="auth.html">
			<ons-page>
				<ons-toolbar>
				  <div class="center">LINEアカウント</div>
				</ons-toolbar>

				<ons-tabbar swipeable position="auto">
					<ons-tab page="tab-login.html" label="ログイン" icon="md-face" active>
					</ons-tab>
					<ons-tab page="tab-register.html" label="アカウント作成" icon="md-settings">
					</ons-tab>
				</ons-tabbar>
			  </ons-page>

		</template>
        <!-- Login tabs -->
        <template id="tab-login.html">
			<ons-page>
				<div id="login" style="text-align: center; margin-top: 30px;">
					<p>お持ちのアカウントでログインします。</p>
				  <p>
					<ons-input id="username" modifier="underbar" placeholder="ユーザID" float></ons-input>
				  </p>
				  <p>
					<ons-input id="password" modifier="underbar" type="password" placeholder="パスワード" float></ons-input>
				  </p>
				  <p style="margin-top: 30px;">
					<ons-button onclick="login()">ログイン</ons-button>
				  </p>
				</div>
			  </ons-page>
		</template>
        <template id="tab-register.html">
			<ons-page>
				<div id="register" style="text-align: center; margin-top: 30px;">
				<p>新しくアカウントを作成します。</p>
				  <p>
					<ons-input id="username" modifier="underbar" placeholder="ユーザID" float></ons-input>
				  </p>
				  <p>
					<ons-input id="password" modifier="underbar" type="password" placeholder="パスワード" float></ons-input>
				  </p>
				  <p>
					<ons-input id="repassword" modifier="underbar" type="password" placeholder="パスワード再入力" float></ons-input>
				  </p>
				  <p style="margin-top: 30px;">
					<ons-button onclick="register()">アカウント作成</ons-button>
				  </p>
				</div>
			  </ons-page>
		</template>








        <!-- Home -->
        <template id="home.html">
			<ons-page ng-controller="TabbarController">
				<ons-toolbar>
					<div class="center">{{title}}</div>
					<div class="right">
							<ons-toolbar-button>
							  <ons-icon icon="ion-add" onclick="add_friend()"> + </ons-icon>
							</ons-toolbar-button>
					</div>
				</ons-toolbar>

				<ons-tabbar swipeable position="auto" ons-prechange="updateTitle($event)">
					<ons-tab page="tab1.html" label="友だち" icon="md-face" active>
					</ons-tab>
					<ons-tab page="tab2.html" label="トーク" icon="md-settings">
					</ons-tab>
				</ons-tabbar>
			</ons-page>
		</template>

        <!-- Home tabs -->
        <template id="tab1.html">
			<ons-page id="Tab1">
				<ons-list id="friends-list">
					<ons-list-header>友だちリスト</ons-list-header>

				</ons-list>
			</ons-page>
		</template>

        <template id="tab2.html">
			<ons-page id="Tab2">
				<ons-list>
					<ons-list-header>トーク履歴</ons-list-header>
				</ons-list>
				<ons-progress-bar indeterminate></ons-progress-bar>
			</ons-page>
		</template>


        <template id="page2.html">
			<ons-page id="page2">
				<ons-toolbar>
					<div class="left">
						<ons-back-button></ons-back-button>
					</div>
					<div class="center">{{ myNavigator.topPage.data.title }}</div>
				</ons-toolbar>

				<p>トークを読み込んでいます.</p>
				<ons-bottom-toolbar>
					<div class="center">
						<ons-input id="message" modifier="material" type="text" placeholder="メッセージを送信" float></ons-input>
					</div>
					<div class="right">
							<ons-toolbar-button>送信</ons-toolbar-button>
					</div>
				</ons-bottom-toolbar>
			</ons-page>
		</template>
        <template id="add-friend.html">
				<ons-page>
						<ons-toolbar>
							<div class="left">
								<ons-back-button></ons-back-button>
							</div>
							<div class="center">友だち追加</div>
						</ons-toolbar>
						<div id="login" style="text-align: center; margin-top: 30px;">
								<p>友だちのユーザIDを入力して追加します。</p>
							  <p>
								<ons-input id="friend-username" modifier="underbar" placeholder="ユーザID" float></ons-input>
							  </p>
							  <p>
							  <p style="margin-top: 30px;">
								<ons-button onclick="add_friend_send()">友だち追加</ons-button>
							  </p>
							</div>
					</ons-page>
			</template>

        <script src="/dist/js/app/home.js"></script>

    </body>

    </html>