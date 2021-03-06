import {useAsyncEffect, useJsonFetchOrFlash} from '/functions/hooks.js'
import {closest} from '/functions/dom.js'
import {flash} from '/Elements/Alert.js'
import {Loader} from '/Components/Loader.jsx'
import {useRef} from 'preact/hooks'
import {redirect} from '/functions/url.js'
import {EVENT_MESSAGE_DELETE} from '/Elements/works/constants.js'
import {canManage} from "/functions/AuthJs";

export function WorksDelete ({ message, topic, owner }) {
    let endpoint = null
    if (message) {
        endpoint = `/api/works2/${topic}`
    } else if (topic) {
        endpoint = `/api/works/${topic}`
    } else {
        throw new Error('Impossible de charger le composant de suppression')
    }

    // On prépare les hooks
    const button = useRef(null)
    const { loading: deleteLoading, fetch: deleteFetch, done } = useJsonFetchOrFlash(endpoint, { method: 'DELETE' })
    useAsyncEffect(async () => {
        if (done) {
            if (message) {
                const message = closest(button.current, '.forum-message')
                flash('Votre message a bien été supprimé')
                document.dispatchEvent(new Event(EVENT_MESSAGE_DELETE))
                message.remove()
            } else {
                await redirect('/workaction')
                flash('Votre sujet a bien été supprimé')
            }
        }
    }, [done, message, topic])


    // Handler
    const handleDeleteClick = async () => {
        if (!confirm('Voulez vous vraiment supprimer ce message ?')) {
            return
        }
        await deleteFetch()
    }

    // L'utilisateur ne peut pas intervenir sur ce sujet
    if (!canManage(owner)) {
        return null
    }

    return (
        <>
            {' '}
            -{' '}
            <button className='text-danger' onClick={handleDeleteClick} disabled={deleteLoading} ref={button}>
                {deleteLoading && <Loader style={{ width: 12, marginRight: 5 }} />}
                Supprimer
            </button>
        </>
    )
}