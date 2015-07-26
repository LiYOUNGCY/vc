<body>
	<?=$sidebar ?>
	<div id="vi_container" class="container">
		<div id="shade"></div>
		<div id="sbtn" class="sbtn">
			<div class="icon">
				<div class="sidebtn"></div>
			</div>
		</div>
		<div class="article-container">
			<div class="detail-box">
				<h1><?=$article['title']?></h1>
				<h5><?=$article['subtitle']?></h5>
				<div class="person-box">
					<div class="author">
						<div class="head"><img src="<?=base_url().'public/'?>img/mm1.jpg"></div>
						<div class="status"><div class="icon"><div class="like"></div></div><span><?=$article['like']?></span></div>
					</div>
				</div>
			</div>
			<div class="article-content">
				<?=$article['content']?>
			</div>
			<div class="playground">
    <div class="box buddycloud">
      <h1>Buddycloud</h1>
      <div class="stream">
        <article class="topic">
          <section class="opener">
            <div class="avatar user2"></div>
            <div class="postmeta">
              <span class="time">3 days</span>
            </div>
            <span class="name">Vera</span><span class="location">from Campus Library</span>
            <p>Pretend. You pretend the feelings are there, for the world, for the people around you.</p>
          </section>
          <div class="hidden">
            <section class="comment">
              <div class="avatar user6"></div>
              <div class="postmeta">
                <span class="time">3 days</span>
              </div>
              <span class="name">Mona</span><span class="location">from Cafe Extra</span>
              <p>Who knows? Maybe one day they will be. I like seafood.</p>
            </section>
            <section class="comment">
              <div class="avatar user7"></div>
              <div class="postmeta">
                <span class="time">3 days</span>
              </div>
              <span class="name">Verena</span><span class="location">from Home</span>
              <p>Finding a needle in a haystack isn't hard when every straw is computerized. I'm really more an apartment person.</p>
            </section>
            <section class="comment">
              <div class="avatar user12"></div>
              <div class="postmeta">
                <span class="time">3 days</span>
              </div>
              <span class="name">Sebastian</span><span class="location">from Passau</span>
              <p>I feel like a jigsaw puzzle missing a piece. And I'm not even sure what the picture should be.</p>
            </section>
            <section class="comment">
              <div class="avatar user3"></div>
              <div class="postmeta">
                <span class="time">3 days</span>
              </div>
              <span class="name">Tom</span><span class="location">from Island</span>
              <p>Who knows? Maybe one day they will be. I like seafood.</p>
            </section>
            <section class="comment">
              <div class="avatar user2"></div>
              <div class="postmeta">
                <span class="time">3 days</span>
              </div>
              <span class="name">Vera</span><span class="location">from Munich</span>
              <p>Finding a needle in a haystack isn't hard when every straw is computerized. I'm really more an apartment person.</p>
            </section>
          </div><!-- /hidden -->
          <section class="seeMore">
            <span>See <span>5</span> More Posts</span>
          </section>
          <section class="comment">
            <div class="avatar user5"></div>
            <div class="postmeta">
              <span class="time">3 days</span>
            </div>
            <span class="name">Gero</span><span class="location">from Regensburg</span>
            <p>I feel like a jigsaw puzzle missing a piece. And I'm not even sure what the picture should be.</p>
          </section>
          <section class="comment">
            <div class="avatar user11"></div>
            <div class="postmeta">
              <span class="time">3 days</span>
            </div>
            <span class="name">Betty</span><span class="location">from Deggendorf</span>
            <p>I'm going to tell you something that I've never told anyone before.</p>
          </section>
        </article>
        <article class="topic">
          <section class="opener">
            <div class="avatar user2"></div>
            <div class="postmeta">
              <span class="time" title="5:06pm 06.06.2011">5 days</span>
            </div>
            <span class="name">Vera</span><span class="location">from Home</span>
            <p>
              Night time - sympathize - I've been working on white lies.
              So I'll tell the truth - I'll give it up to you.
              And when the day come, it will have all been fun. We'll talk about it soon.
            </p>
          </section>
          <section class="answer">
            <div class="avatar user1"></div>
            <textarea placeholder="post a comment..."></textarea>
            <div class="controls">
              <div class="button small prominent">Post</div>
            </div>
          </section>
        </article>
      </div>
    </div>
  </div>
		</div>
	</div>
</body>
</html>