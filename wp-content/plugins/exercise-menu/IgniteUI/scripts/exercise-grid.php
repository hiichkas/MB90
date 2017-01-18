<!-- Ignite UI Required Combined CSS Files -->
<link href="http://cdn-na.infragistics.com/igniteui/2014.2/latest/css/themes/infragistics/infragistics.theme.css" rel="stylesheet" />
<link href="http://cdn-na.infragistics.com/igniteui/2014.2/latest/css/structure/infragistics.css" rel="stylesheet" />

<script src="http://modernizr.com/downloads/modernizr-latest.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

<!-- Ignite UI Required Combined JavaScript Files -->
<script src="http://cdn-na.infragistics.com/igniteui/2014.2/latest/js/infragistics.core.js"></script>
<script src="http://cdn-na.infragistics.com/igniteui/2014.2/latest/js/infragistics.lob.js"></script>


    <style type="text/css">
        .labelBackGround {
            text-align: right;
            margin-right: 10px;
        }
    </style>

    <!--Sample JSON Data-->
    <script src="http://www.igniteui.com/data-files/northwind.js"></script>

    <!-- Target element for the igGrid -->
    <table id="grid">
    </table>

    <script id="rowEditDialogRowTemplate1" type="text/x-jquery-tmpl">
        <tr>
            <td class="labelBackGround">${headerText}
                {{if ${dataKey} == 'BirthDate'}}<span style="color: red;">*</span>{{/if}}
            </td>
            <td data-key='${dataKey}'>
                <input />
            </td>
        </tr>
    </script>

    <script type="text/javascript">
        $( function ()
        {

            var titles = ["Sales Representative", "Sales Manager", "Inside Sales Coordinator", "Vice President, Sales"];
            var countries = ["UK", "USA"];

            /*----------------- Instantiation -------------------------*/
            $( "#grid" ).igGrid( {
                virtualization: false,
                autoGenerateColumns: false,
                renderCheckboxes: true,
                primaryKey: "EmployeeID",
                columns: [{
                    // note: if primaryKey is set and data in primary column contains numbers,
                    // then the dataType: "number" is required, otherwise, dataSource may misbehave
                    headerText: "Employee ID", key: "EmployeeID", dataType: "number"
                },
                    {
                        headerText: "First Name", key: "FirstName", dataType: "string"
                }, {
                    headerText: "Last Name", key: "LastName", dataType: "string"
                }, {
                    headerText: "Title", key: "Title", dataType: "string"
                }, {
                    headerText: "Birth Date", key: "BirthDate", dataType: "date"
                }, {
                    headerText: "Postal Code", key: "PostalCode", dataType: "string"
                }, {
                    headerText: "Country", key: "Country", dataType: "string"
                }
                ],
                dataSource: northwind,
                dataSourceType: "json",
                responseDataKey: "results",
                width: "100%",
                tabIndex: 1,
                features: [
                    {
                        name: 'Responsive',
                        enableVerticalRendering: false,
                        columnSettings: [
                            {
                                columnKey: 'EmployeeID',
                                classes: 'ui-hidden-phone'
                            },
                            {
                                columnKey: 'PostalCode',
                                classes: 'ui-hidden-phone'
                            },
                            {
                                columnKey: 'BirthDate',
                                classes: 'ui-hidden-phone'
                            }
                        ]
                    },
                    {
                        name: "Selection",
                        mode: "row"
                    },
                    {
                        name: "Updating",
                        enableAddRow: false,
                        editMode: "rowedittemplate",
                        rowEditDialogWidth: 280,
                        rowEditDialogHeight: '280',
                        rowEditDialogContentHeight: 300,
                        rowEditDialogFieldWidth: 150,
                        rowEditDialogContainment: "window",
                        rowEditDialogRowTemplateID: "rowEditDialogRowTemplate1",
                        enableDeleteRow: false,
                        showReadonlyEditors: false,
                        showDoneCancelButtons: true,
                        enableDataDirtyException: false,
                        columnSettings: [
                            {
                                columnKey: "EmployeeID",
                                readOnly: true
                            }, {
                                columnKey: "Title",
                                editorType: "text",
                                editorOptions: {
                                    button: "dropdown",
                                    listItems: titles,
                                    readOnly: true,
                                    dropDownOnReadOnly: true
                                }
                            }, {
                                columnKey: "Country",
                                editorType: "text",
                                editorOptions: {
                                    button: "dropdown",
                                    listItems: countries,
                                    readOnly: true,
                                    dropDownOnReadOnly: true
                                }
                            },
                    {
                        columnKey: "BirthDate",
                        editorType: "datepicker",
                        validation: true,
                        editorOptions: { minValue: new Date( 1955, 1, 19 ), maxValue: new Date(), required: true },
                        validatorOptions: { bodyAsParent: false }
                    }
                        ]
                    }
                ]
            } );

        } );

    </script>
</body>
</html>