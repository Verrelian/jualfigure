<!-- Modal Like + Comment FIX Version -->
<div id="postModal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4 overflow-y-auto">
  <div class="bg-white rounded-2xl shadow-xl max-w-3xl w-full overflow-hidden relative">

    <!-- Close Button -->
    <button onclick="closePostModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>

    <!-- Modal Content -->
    <div class="grid grid-cols-1 md:grid-cols-2">
      <!-- Carousel -->
      <div class="bg-black flex items-center justify-center">
        <div class="swiper w-full h-full">
          <div class="swiper-wrapper" id="modalPostImages">
            <!-- Slides injected here -->
          </div>
          <div class="swiper-pagination"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
      </div>

      <!-- Post Info -->
      <div class="p-6 space-y-4">
        <div>
          <h2 id="modalPostTitle" class="text-xl font-bold text-gray-900"></h2>
          <p id="modalPostTime" class="text-sm text-gray-500"></p>
        </div>
        <p id="modalPostDescription" class="text-gray-700 text-sm leading-relaxed"></p>

        <!-- Like & Toggle Comment -->
        <div class="border-t pt-4 mt-4">
          <form id="modalLikeForm" method="POST" class="inline">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-red-500 transition-colors group">
              <div class="p-2 rounded-full group-hover:bg-red-50 transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                           2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5
                           2.09C13.09 3.81 14.76 3 16.5 3 19.58 3
                           22 5.42 22 8.5c0 3.78-3.4 6.86-8.55
                           11.54L12 21.35z"/>
                </svg>
              </div>
              <span class="font-medium" id="modalLikeCount">0</span>
            </button>
          </form>

          <button onclick="openCommentPopup()" class="mt-4 text-sm text-blue-600 hover:underline">
            View Comments
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Comment Popup Modal -->
<div id="commentPopup" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4">
  <div class="bg-white rounded-xl w-full max-w-md p-4 max-h-[80vh] overflow-y-auto">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold">Comments</h3>
      <button onclick="closeCommentPopup()" class="text-gray-500 hover:text-gray-700">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <form id="modalCommentForm" method="POST" class="space-y-2">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="flex gap-2">
        <input type="text" name="comment" id="modalCommentInput" placeholder="Write a comment..."
               class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded-full text-sm">
        <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm">
          Send
        </button>
      </div>
    </form>
    <div id="modalCommentsContainer" class="mt-4 space-y-3 text-sm text-gray-700">
      <!-- Comments will be injected here -->
    </div>
  </div>
</div>

<!-- SwiperJS CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  let modalSwiper;
  let currentPostId = null;

  function openPostModal(post) {
    currentPostId = post.id;
    document.getElementById('modalPostTitle').textContent = post.title;
    document.getElementById('modalPostDescription').textContent = post.description;
    document.getElementById('modalPostTime').textContent = post.time;
    document.getElementById('modalLikeCount').textContent = post.likes_count;

    const wrapper = document.getElementById('modalPostImages');
    wrapper.innerHTML = '';
    post.images.forEach(url => {
      const slide = document.createElement('div');
      slide.classList.add('swiper-slide');
      slide.innerHTML = `<div class="flex items-center justify-center h-[500px]">
        <img src="${url}" class="max-h-full max-w-full object-contain mx-auto rounded-xl" />
      </div>`;
      wrapper.appendChild(slide);
    });

    const container = document.getElementById('modalCommentsContainer');
    container.innerHTML = '';
    post.comments.forEach(comment => {
      const div = document.createElement('div');
      div.className = 'flex items-start gap-2';
      div.innerHTML = `
        <img src="${comment.buyer_avatar}" class="h-8 w-8 rounded-full" alt="avatar">
        <div>
          <p class="font-semibold">${comment.username}</p>
          <p>${comment.comment}</p>
        </div>
      `;
      container.appendChild(div);
    });

    if (modalSwiper) modalSwiper.destroy(true, true);
    modalSwiper = new Swiper('.swiper', {
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });

    document.getElementById('postModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closePostModal() {
    document.getElementById('postModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
  }

  function openCommentPopup() {
    document.getElementById('commentPopup').classList.remove('hidden');
  }

  function closeCommentPopup() {
    document.getElementById('commentPopup').classList.add('hidden');
  }

  document.getElementById('modalLikeForm').addEventListener('submit', function (e) {
    e.preventDefault();
    fetch(`/mole/profile/posts/${currentPostId}/like`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    .then(res => res.json())
    .then(data => {
      document.getElementById('modalLikeCount').textContent = data.total_likes;
    });
  });

  document.getElementById('modalCommentForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const comment = document.getElementById('modalCommentInput').value;
    fetch(`/mole/profile/posts/${currentPostId}/comment`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ comment })
    })
    .then(res => res.json())
    .then(data => {
      const div = document.createElement('div');
      div.className = 'flex items-start gap-2';
      div.innerHTML = `
        <img src="${data.buyer_avatar}" class="h-8 w-8 rounded-full" alt="avatar">
        <div>
          <p class="font-semibold">${data.username}</p>
          <p>${data.comment}</p>
        </div>
      `;
      document.getElementById('modalCommentsContainer').appendChild(div);
      document.getElementById('modalCommentInput').value = '';
    });
  });
</script>
