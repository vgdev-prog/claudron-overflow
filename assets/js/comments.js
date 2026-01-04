const app = {
    container: document.querySelector('.js-vote-arrows'),
    links: document.querySelectorAll('.js-vote-arrows a#vote'),
}

const handleClickVoteBtn = async (e) => {
    e.preventDefault();

    const voteMark = e.currentTarget.closest('.js-vote-arrows').querySelector('.js-vote-total')

    console.log()

    const res = await fetch(`/answers/${e.currentTarget.dataset.id}/vote/${e.currentTarget.dataset.direction}`,{
        method:'POST'
    })
  const data = await res.json();
    voteMark.textContent = data.votes;
}


app.links.forEach(link => {
    link.addEventListener('click', handleClickVoteBtn)
})


