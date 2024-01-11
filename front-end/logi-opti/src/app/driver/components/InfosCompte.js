
export default function InfosCompte({user}) {

    if (!user) return <div>Loading...</div>;
    return(
        <div className="flex flex-col gap-5 items-center justify-center bg-white px-5 shadow-box py-5">
            <h2 className="u-semi text-xl underline text-center"> Informations du compte</h2>
            <div className="mt-5 w-full">
                <label className="u-m text-sm">Nom</label>
                <input defaultValue={user.lastName} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
            </div>
            <div className="mt-5 w-full">
                <label className="u-m text-sm">Prenom</label>
                <input defaultValue={user.firstName}  className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1 " type="text" />
            </div>
            <div className="mt-5 w-full">
                <label className="u-m text-sm">Adresse e-mail</label>
                <input defaultValue={user.email} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
            </div>
            <div className="mt-5 w-full">
                <label className="u-m text-sm">Mot de passe (Non modifiable)</label>
                <input disabled  defaultValue={"rgjgijrgirjr"} type="password" className="bg-slate-200 w-full h-10 rounded px-5 u-r mt-1 text-3xl disabled" />
            </div>
            <div className="mt-5 w-full">
                <label className="u-m text-sm">Vehicule de base</label>
                <input defaultValue={"Renault Master"} className="bg-redFullClair w-full h-10 rounded px-5 u-r mt-1" type="text" />
            </div>
            <button type="button" className=" mt-5 inline-flex w-full justify-center rounded-md bg-redFull px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-redFullClair sm:ml-3 sm:w-auto">Enregistrer</button>
        </div>
    );
}