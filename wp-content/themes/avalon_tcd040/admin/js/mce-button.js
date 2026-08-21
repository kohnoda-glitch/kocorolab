(function() {
  // ビジュアルエディタにプルダウンメニューの追加
	tinymce.PluginManager.add('my_mce_button', function( editor, url ) {
		editor.addButton( 'my_mce_button', {
			text: 'クイックタグ',
			icon: false,
			type: 'menubutton',
			menu: [
				{
							text: 'Youtube動画',
							onclick: function() {
								editor.insertContent('<div class="ytube">ここにYoutubeのコードを入力してください</div>');
							}
				},
				{
							text: '関連記事カードリンク',
							onclick: function() {
								editor.insertContent('[clink url="ここに表示させたい記事URL"]');
							}
				},
				{
							text: 'レイアウト2c',
							onclick: function() {
								editor.insertContent('<div class="post_row"><div class="post_col post_col-2">ここに左カラムに表示させたい任意のテキストや画像タグを入力します。</div><div class="post_col post_col-2">ここに右カラムに表示させたい任意のテキストや画像タグを入力します。</div></div>');
							}
				},
				{
							text: 'レイアウト3c',
							onclick: function() {
								editor.insertContent('<div class="post_row"><div class="post_col post_col-3">ここに左カラムに表示させたい任意のテキストや画像タグを入力します。</div><div class="post_col post_col-3">ここに中央カラムに表示させたい任意のテキストや画像タグを入力します。</div><div class="post_col post_col-3">ここに右カラムに表示させたい任意のテキストや画像タグを入力してください。</div></div>');
							}
				},
				{
							text: 'H3見出しa',
							onclick: function() {
								editor.insertContent('<h3 class="style3a">H3見出しa</h3>');
							}
				},
				{
							text: 'H3見出しb',
							onclick: function() {
								editor.insertContent('<h3 class="style3b">H3見出しb</h3>');
							}
				},
				{
							text: 'H4見出しa',
							onclick: function() {
								editor.insertContent('<h4 class="style4a">H4見出しa</h4>');
							}
				},
				{
							text: 'H4見出しb',
							onclick: function() {
								editor.insertContent('<h4 class="style4b">H4見出しb</h4>');
							}
				},
				{
							text: 'H5見出しa',
							onclick: function() {
								editor.insertContent('<h5 class="style5a">H5見出しa</h5>');
							}
				},
				{
							text: 'H5見出しb',
							onclick: function() {
								editor.insertContent('<h5 class="style5b">H5見出しb</h5>');
							}
				},
				{
							text: '囲み枠a',
							onclick: function() {
								editor.insertContent('<div class="well">囲み枠a</div>');
							}
				},
				{
							text: '囲み枠b',
							onclick: function() {
								editor.insertContent('<div class="well2">囲み枠b</div>');
							}
				},
				{
							text: '囲み枠c',
							onclick: function() {
								editor.insertContent('<div class="well3">囲み枠c</div>');
							}
				},
				{
							text: 'フラットボタン',
							onclick: function() {
								editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button">フラットボタン</a></div>');
							}
				},
				{
							text: 'フラットボタン-L',
							onclick: function() {
								editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button sz_l">フラットボタン-L</a></div>');
							}
				},
				{
							text: 'フラットボタン-S',
							onclick: function() {
								editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button sz_s">フラットボタン-S</a></div>');
							}
				},
				{
							text: 'フラットボタン-blue',
							onclick: function() {
								editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button bt_blue">フラットボタン-blue</a></div>');
							}
				},
				{
							text: 'フラットボタン-green',
							onclick: function() {
                             editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button bt_green">フラットボタン-green</a></div>');
							}
				},
				{
							text: 'フラットボタン-red',
							onclick: function() {
                             editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button bt_red">フラットボタン-red</a></div>');
							}
				},
				{
							text: 'フラットボタン-yellow',
							onclick: function() {
                             editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button bt_yellow">フラットボタン-yellow</a></div>');
							}
				},
				{
							text: '角丸ボタン',
							onclick: function() {
								editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button rounded">角丸ボタン</a></div>');
							}
				},
				{
							text: '角丸ボタン-L',
							onclick: function() {
								editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button rounded sz_l">角丸ボタン-L</a></div>');
							}
				},
				{
							text: '角丸ボタン-S',
							onclick: function() {
								editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button rounded sz_s">角丸ボタン-S</a></div>');
							}
				},
				{
							text: 'ラウンドボタン',
							onclick: function() {
								editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button pill">ラウンドボタン</a></div>');
							}
				},
				{
							text: 'ラウンドボタン-L',
							onclick: function() {
								editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button pill sz_l">ラウンドボタン-L</a></div>');
							}
				},
				{
							text: 'ラウンドボタン-S',
							onclick: function() {
								editor.insertContent('<div class="q_button_wrap"><a href="#" class="q_button pill sz_s">ラウンドボタン-S</a></div>');
							}
				},
				{
							text: '広告',
							onclick: function() {
								editor.insertContent('[s_ad]');
							}
				}
			]
		});
	});
})();