$(document).ready(function () {
    $.get(
      "http://localhost/News-Website/backend/connection.php",
      function (data) {
        let newsData = JSON.parse(data);
        if (Array.isArray(newsData) && newsData.length > 0) {
          let allNews = $("#all-news");
          allNews.empty();
          $.each(newsData, function (index, item) {
            allNews.append(
                "<p>" + item.title + "</p>" +
                "<p>" + item.text + "</p>"
            );
          });
        } else {
          $("#all-news").html("<p>There are no articles yet.</p>");
        }
      }
    ).fail(function (xhr, status, error) {
      console.error("Error fetching news: " + error);
    });

    $("#news-form").submit(function (event) {
        event.preventDefault();
        let formData = $(this).serialize();
        $.post(
            "http://localhost:4433/News-Website/backend/connection.php",
            formData,
            function (response) {
                console.log(response);
                $.get(
                    "http://localhost:4433/News-Website/backend/connection.php",
                    function (data) {
                        let allNews = $("#all-news");
                        allNews.empty();
                        let newsData = JSON.parse(data);
                        if (Array.isArray(newsData) && newsData.length > 0) {
                            $.each(newsData, function (index, item) {
                                allNews.append(
                                    "<p>" + item.title + "</p>" +
                                    "<p>" + item.text + "</p>"
                                );
                            });
                        } else {
                            $("#all-news").html("<p>No news articles found.</p>");
                        }
                    }
                );
                $("#news-form")[0].reset();
            }
        );
    });
});
