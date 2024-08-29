<?php session_start(); ?>



<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign in - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <link href="./dist/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css?1692870487" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">

        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Enter verification code</h2>
            <form action="action/opt.php" method="post" autocomplete="off" novalidate>
            <div class="mb-3">
              <label class="form-label">Verification code sent</label>
              <div class="input-group input-group-flat">
                <input type="text" name="opt" style="text-align: center;" class="form-control"  autocomplete="one-time-code" maxlength="4" inputmode="numeric" value="">
              </div>
            </div>
              <div class="form-footer">
                <input type="submit" name="verify" class="btn btn-primary w-100" placeholder="send OPT">
              </div>
            </form><br>
            <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
  <div class="alert alert-important alert-danger alert-dismissible" role="alert">
    <div class="d-flex">
    <div>
    <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
      </div>
        <div>
        <?php foreach ($_SESSION['errors'] as $error): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
        </div>
      </div>
  </div>
<?php unset($_SESSION['errors']); // Clear errors after displaying ?>
<?php endif; ?>
          </div>
      </div>
      <div class="text-center text-secondary mt-3">
          Don't receive code yet? <a href="./signup.php" tabindex="-1">Send again</a>
        </div>
    </div>
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
  </body>
</html>