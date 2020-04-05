$(document).ready(function() {
  const $form = $('.js-form');
  // 投稿を読み込み
  const loadPosts = function() {
    $.ajax({
      type: "GET",
      url: "/api/getPost.php",
      dataType: "json",
      success: function (data) {
        const $posts =$(".js-load-posts");
        $posts.empty();
        for (const d of data) {
          const comments = d["comment"].split("\n");
          const commentsElem = (function() {
            let elem = "";
            for(const comment of comments) {
              elem += `<p>${comment}<\p>`;
            }
            return elem;
          })();
          const postElem = `
          <div class="post-row">
            <div class="comment-head">
              <p>【${d["name"]}】${d["created_at"]}</p>
            </div>
            <div class="comment-body">
              ${commentsElem}
            </div>
          </div>
          `;
          $posts.append(postElem);
        }
      }
    });
  };
  // エラーメッセージを表示
  const displayErrors = function(errors) {
    for(const field in errors) {
      const $target = $(".form").find(`.${field}`);
      const errorElem = `
      <div class="err-msg">
        <p>${errors[field]}</p>
      </div>
      `;
      $target.before(errorElem);
    }
  }
  // ページ読み込み時実行
  const initialize = (function() {
    loadPosts();
  })();
  // 投稿イベント
  $('.js-form').submit(function(e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $(this).find(".err-msg").remove();
    $.ajax({
      type: "POST",
      url: "/api/sendPost.php",
      data: formData,
      dataType: "json",
      success: function (result) {
        if (result.code === 422) {
          displayErrors(result.data);
        } else {
          loadPosts();
        }
      },
      error: function(e) {
        console.log(e);
      }
    })
  });
});
