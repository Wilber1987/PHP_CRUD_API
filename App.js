import { WAppNavigator } from "./public/WDevCore/WComponents/WAppNavigator.js";
import { WRender, ComponentsManager, WAjaxTools } from './public/WDevCore/WModules/WComponentsTools.js';
import { WCssClass } from './public/WDevCore/WModules/WStyledRender.js';
import { WTableComponent } from "./public/WDevCore/WComponents/WTableComponent.js";
import { StylesControlsV2 } from "./public/WDevCore/StyleModules/WStyleComponents.js";
import { Security_Permissions, Security_Roles, Security_Users } from "./public/MODEL_JS/SecurityModel.js";
window.onload = async ()=>{    
    /*const respons2 = await WAjaxTools.PostRequest("./API/ApiController.php/?function=SaveSecurity_Permissions", {
        Descripcion: "PHP TEST", Estado: "ACTIVO"
    });
    const respons3 = await WAjaxTools.PostRequest("./API/ApiController.php/?function=UpdateSecurity_Permissions", {
        Id_Permission: 1 , Descripcion: "PHP TEST Update", Estado: "ACTIVO"
    });*/
    const DOMManager = new ComponentsManager({ MainContainer: Main }); //MAIN ES EL ID DEL DIV QUE CONTENDRA LOS ELEMENTOS
    const Roles = []//await WAjaxTools.PostRequest("./API/ApiController.php/?function=GetSecurity_Roles", {});
    const Permisos = await WAjaxTools.PostRequest("./API/ApiController.php/?function=GetSecurity_Permissions", {});
    Header.append(WRender.createElement(StylesControlsV2));
    Header.append(WRender.Create({tagName: "h3", innerText: "Mantenimiento de Usuarios"}));
    Header.append(new WAppNavigator({
        DarkMode: false,
        Direction: "row",//column
        Elements: [
            ElementTab("Permisos", DOMManager, new Security_Permissions()),
            ElementTab("Roles", DOMManager, new Security_Roles({
                Security_Permissions_Roles: { type: "multiselect", Dataset: Permisos }
            })),            
            ElementTab("Usuarios", DOMManager, new Security_Users({
                Security_Users_Roles: { type: "multiselect", Dataset: Roles }
            })),
        ]
    }));
    
}
function ElementTab(TabName = "Tab", DOMManager, Model) {
    return {
        name: TabName, url: "#",
        action: async (ev) => {
            const response = await WAjaxTools.PostRequest("./API/ApiController.php/?function=Get" + Model.constructor.name, {});
            DOMManager.NavigateFunction(Model.constructor.name, new WTableComponent({
                Dataset: response,
                ModelObject: Model,
                Options: {
                    Add: true, UrlAdd: "./API/ApiController.php/?function=Save" + Model.constructor.name,
                    Edit: true, UrlUpdate: "./API/ApiController.php/?function=Update" + Model.constructor.name,
                    Search: true, UrlSearch: "./API/ApiController.php/?function=Get" + Model.constructor.name,
                }
            }));
        }
    };
}