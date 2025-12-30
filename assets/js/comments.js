const app = {
    container: document.querySelector('.js-vote-arrows'),
    links: document.querySelectorAll('.js-vote-arrows a'),
}

const handleClickVoteBtn = async (e) => {
    e.preventDefault();

    const voteMark = app.container.querySelector('.js-vote-total')

    const res = await fetch(`/comments/10/vote/${e.currentTarget.dataset.direction}`,{
        method:'POST'
    })
  const data = await res.json();
    voteMark.textContent = data.votes
}


app.links.forEach(link => {
    link.addEventListener('click', handleClickVoteBtn)
})


