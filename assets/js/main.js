document.addEventListener('DOMContentLoaded', () => {
    const enrolls = document.querySelectorAll('.eventr-enroll')
    const submits = document.querySelectorAll('.eventr-submit')
    const exits = document.querySelectorAll('.eventr-exit')
    for (const item of enrolls) {
        const front = item.parentNode
        const back = front.nextElementSibling
        item.addEventListener('click', () => {
            front.classList.add('flip')
            setTimeout(() => {
                back.classList.add('flip')
            }, 200)
        })
    }
    for (const item of exits) {
        const front = item.parentNode.parentNode
        const back = front.previousElementSibling
        item.addEventListener('click', () => {
            front.classList.remove('flip')
            setTimeout(() => {
                back.classList.remove('flip')
            }, 200)
        })
    }

    for (const item of submits) {
        item.addEventListener('click', async () => {
            const parent = item.parentNode
            const cont = parent.parentNode
            const data = new FormData();
            for (const el of parent.children) {
                if (el.classList.contains('eventr-input')) {
                    const name = el.getAttribute('name')
                    data.append(name, el.value)
                }
            }
            for (const [key, value] of Object.entries(window.eventr.text)) {
                data.append(`t-${key}`, value)
            }
            console.info('Eventr: sending...\n', console.log(Object.fromEntries(data)))
            try {
                let res = await fetch('/?rest_route=/eventr/mail', {
                    body: data,
                    method: 'POST'
                })
                let val = await res.json();
                if (val == 'OK') {
                    cont.classList.add('done')
                    cont.innerHTML = `
                        <div class="eventr-sent">
                            <div class="eventr-okay">${eventr.icons.okay}</div>
                        </div>
                        <div class="eventr-done">${eventr.text.submission}</div>
                    `
                }
                else {
                    cont.innerHTML = `
                        <div class="eventr-sent">
                            <div>ERROR</div>
                            <div style="font-size: 15px">${val}</div>
                        </div>
                    `
                }
            }
            catch (err) {
                console.error('Eventr error', err);
            }
        })
    
    }
})