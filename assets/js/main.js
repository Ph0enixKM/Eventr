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

    function validate(el, parent) {
        if (el.classList.contains('eventr-select')) return true
        if (el.classList.contains('eventr-checkbox')) {
            if (!el.checked) {
                for (const item of parent.children)
                    item.classList.remove('bad')
                el.classList.add('bad')
                return false
            }
        }
        else {
            if (!el.value.trim().length) {
                for (const item of parent.children)
                    item.classList.remove('bad')
                el.classList.add('bad')
                return false
            }
        }
        return true
    }

    for (const item of submits) {
        item.addEventListener('click', async function _ () {
            const form = item.parentNode.previousElementSibling
            const data = new FormData();
            for (const el of form.children) {
                if (el.classList.contains('eventr-input')) {
                    const name = el.getAttribute('name')
                    // Checkbox case
                    if (el.classList.contains('eventr-checkbox')){
                        data.append(name, (el.checked) ? '✔' : '❌')
                    }
                    // Input case
                    else {
                        if (el.type == 'email') {
                            window.eventr.text.emailConfirm = el.value
                        }
                        data.append(name, el.value)
                    }
                    if (el.classList.contains('eventr-req'))
                        if (!validate(el, form)) return
                }
            }
            for (const [key, value] of Object.entries(window.eventr.text)) {
                data.append(`_${key}`, value)
            }
            console.info(data);
            try {
                item.style.opacity = '0.5'
                item.removeEventListener('click', _)
                item.nextElementSibling.remove()
                let res = await fetch('/?rest_route=/eventr/mail', {
                    body: data,
                    method: 'POST'
                })
                let val = await res.json();
                if (val == 'OK') {
                    form.parentElement.classList.add('done')
                    form.parentElement.innerHTML = `
                        <div class="eventr-sent">
                            <div class="eventr-okay">${eventr.icons.okay}</div>
                        </div>
                        <div class="eventr-done">${eventr.text.submission}</div>
                    `
                }
                else {
                    form.parentElement.innerHTML = `
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