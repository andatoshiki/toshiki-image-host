<?php

/** 禁止直接访问 */
defined('APP_ROOT') ?: exit;
/** 弹窗公告 */
if ($config['notice_status'] == 1 && !empty($config['notice'])) : ?>
  <div class="modal fade" id="notice">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">x</span>
            <span class="sr-only">关闭</span></button>
          <p class="modal-title icon icon-bell" style="text-align: center"> 网站公告</p>
        </div>
        <div class="modal-body">
          <?php echo $config['notice']; ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
<!-- 二维码 -->
<div class="modal fade" id="qr">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">x</span>
          <span class="sr-only">关闭</span></button>
        <p class="modal-title icon icon-mobile" style="text-align: center">扫描二维码使用手机上传</p>
      </div>
      <div class="modal-body">
        <p id="qrcode"></p>
      </div>
    </div>
  </div>
</div>
<footer class="container text-muted small navbar-fixed-bottom" style="text-align: center;background-color:rgba(255,255,255,0.7);z-index: 0;">
  <hr>
  <?php /** 页脚信息 */ if (!empty($config['footer'])) echo $config['footer']; ?>
  <p>
        <?php echo 'Copyright © 2022-' . date('Y'); ?>
        <a href="https://image.toshiki.top/" target="_blank">俊樹の圖床</a> By
        <a href="https://www.toshiki.top/" target="_blank">Anda Toshiki</a> |
    <a href="/admin/terms.php" target="_blank"> DMCA</a>
    <!-- 二维码按钮 -->
    <a data-toggle="modal" href="#qr" title="使用手机扫描二维码访问"><i class="icon icon-qrcode hidden-xs inline-block"></i></a>
    <?php
    // 登录与退出    
    if (is_who_login('admin') || is_who_login('guest')) {
      echo '<a href="' . $config['domain'] . '/admin/index.php?login=logout" title="退出账号"><i class="icon icon-signout"></i></a>';
    } else {
      echo '<a href="' . $config['domain'] . '/admin/index.php" title="账号登录"><i class="icon icon-user"></i></a>';
    }
    ?>
  </p>
</footer>
<link href="<?php static_cdn(); ?>/public/static/nprogress/nprogress.min.css" rel="stylesheet">
<script src="<?php static_cdn(); ?>/public/static/nprogress/nprogress.min.js"></script>
<script src="<?php static_cdn(); ?>/public/static/qrcode/qrcode.min.js"></script>
<script>
  // 导航状态
  $('.nav-pills').find('a').each(function() {
    if (this.href == document.location.href) {
      $(this).parent().addClass('active'); // this.className = 'active';
    }
  });

  // NProgress
  NProgress.start();
  NProgress.done();

  // js 获取当前网址二维码
  var qrcode = new QRCode(document.getElementById("qrcode"), {
    text: window.location.href,
    width: 265,
    height: 256,
    colorDark: "#353535",
    colorLight: "#F1F1F1",
    correctLevel: QRCode.CorrectLevel.H
  });

  // 二维码对话框属性
  $('#qr').modal({
    moveable: "inside",
    backdrop: false,
    show: false,
  })

  <?php /** 弹窗公告控制 */ if ($config['notice_status'] == 1 && !empty($config['notice'])) : ?>
    if (document.cookie.indexOf("noticed=") == -1) {
      $('#notice').modal({
        backdrop: false,
        loadingIcon: "icon-spin",
        scrollInside: true,
        moveable: "inside",
        rememberPos: true,
        scrollInside: true
      }).on('hidden.zui.modal', function() {
        // 只有用户手动关闭才会存储cookie,避免不看公告直接刷新
        document.cookie = "noticed =1";
        console.log('网站公告已显示完毕')
      })
    }
  <?php endif; ?>

  <?php /** 简繁转换 */ if ($config['language'] == 1) : ?>
    $.getScript("<?php static_cdn(); ?>/public/static/i18n/jquery.s2t.js", function() { //加载成功后，并执行回调函数
      $('*').s2t();
    });
  <?php endif; ?>
</script>
</body>

</html>