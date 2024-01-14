export default function TrajetsAVenir({openAjout,openUpdate,setOpenAjout,setOpenUpdate}) {



    const shouldDisplayModal = openAjout || openUpdate;

    return (
        (shouldDisplayModal  && 
        <div className="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div className="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div className="fixed inset-0 z-50 w-screen overflow-y-auto">
                <div className="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">

                <div className="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div className="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div className="sm:flex sm:items-start">
                        <div className="mt-3 sm:ml-4 sm:mt-0 sm:text-left">
                        {openAjout ? (
                        <h3 className="u-semi text-2xl leading-6 text-center text-gray-900" id="modal-title">Ajout du trajet</h3>
                        ): (
                        <h3 className="u-semi text-2xl leading-6 text-center text-gray-900" id="modal-title">Modification du trajet</h3>
                        )}
                        <div className="mt-5 w-full">
                            <label className="u-m text-sm">Adresse de départ</label>
                            <input defaultValue={openUpdate ? "39 rue Guy de maupassant" : undefined}  className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1 " type="text" />
                        </div>
                        <div className="mt-5 w-full flex gap-2">
                            <div className="w-6/12">
                                <label className="u-m text-sm">Ville</label>
                                <input defaultValue={openUpdate ? "Lyon" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                            <div className="w-6/12">
                                <label className="u-m text-sm">Code Postale</label>
                                <input defaultValue={openUpdate ? "69000" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                        </div>
                        <div className="mt-5 w-full flex gap-2">
                            <div className="w-6/12">
                                <label className="u-m text-sm">Région</label>
                                <input defaultValue={openUpdate ? "Rhône Alpes" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                            <div className="w-6/12">
                                <label className="u-m text-sm">Date de départ</label>
                                <input defaultValue={openUpdate ? "France" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                        </div>
                        <div className="mt-5 w-full">
                            <label className="u-m text-sm">Adresse de la destination</label>
                            <input defaultValue={openUpdate ? "39 rue Guy de maupassant" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                        </div>
                        <div className="mt-5 w-full flex gap-2">
                            <div className="w-6/12">
                                <label className="u-m text-sm">Ville</label>
                                <input defaultValue={openUpdate ? "Marseille" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                            <div className="w-6/12">
                                <label className="u-m text-sm">Code Postale</label>
                                <input defaultValue={openUpdate ? "13000" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                        </div>
                        <div className="mt-5 w-full flex gap-2">
                            <div className="w-6/12">
                                <label className="u-m text-sm">Région</label>
                                <input defaultValue={openUpdate ? "PACA" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                            <div className="w-6/12">
                                <label className="u-m text-sm">Date de départ</label>
                                <input defaultValue={openUpdate ? "France" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                        </div>
                        <div className="mt-5 w-full">
                            <label className="u-m text-sm">Type de véhicule</label>
                            <input defaultValue={openUpdate ? "Renault Master" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                        </div>
                        <div className="mt-5 w-full flex gap-2">
                            <div className="w-6/12">
                                <label className="u-m text-sm">Charge du véhicule</label>
                                <input defaultValue={openUpdate ? "57.75 €" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                            <div className="w-6/12">
                                <label className="u-m text-sm">Date de départ</label>
                                <input defaultValue={openUpdate ? "45.76 €" : undefined} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
                            </div>
                        </div>
                    
                    </div>
                    </div>
                    </div>
                    <div className="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button onClick={()=>{ setOpenAjout(false);setOpenUpdate(false)}} type="button" className="inline-flex w-full justify-center rounded-md bg-redFull px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-redFullClair sm:ml-3 sm:w-auto">{openUpdate ? "Modifier" : "Ajouter"} un trajet</button>
                    <button onClick={()=>{ setOpenAjout(false);setOpenUpdate(false)}} type="button" className="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Annuler</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        )
    );

}