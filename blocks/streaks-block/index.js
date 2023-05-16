(function (blocks, element) {
    const { registerBlockType } = blocks;
    const { createElement } = element;

    function onChangeId(input, props) {
        props.setAttributes({ id: parseInt(input.target.value) });
    }

    function edit(props) {
        // get all attributes from props then create element for each
        const { attributes: { id, count, color, button_color, streak_connection_color, class_name, timezone, today_color }, setAttributes, className } = props;

        // create element group
        return createElement("div", { className: className },
            createElement("div", { className: "form-group" },
                createElement("label", { htmlFor: "id" }, "Enter ID"),
                createElement("input", {
                    type: "number",
                    id: "id",
                    placeholder: "Enter ID",
                    value: id,
                    onChange: (input) => onChangeId(input, props)
                })
            ),
            createElement("div", { className: "form-group" },
                createElement("label", { htmlFor: "count" }, "Enter Count"),
                createElement("input", {
                    type: "number",
                    id: "count",
                    placeholder: "Enter Count",
                    value: count,
                    onChange: (input) => setAttributes({ count: parseInt(input.target.value) })
                })
            ),
           // create element for colorpicker, show colorpicker when click on input
            createElement("div", { className: "form-group" },
                createElement("label", { htmlFor: "color" }, "Choose Color"),
                createElement(wp.components.ColorPicker, {
                    color: color,
                    onChangeComplete: (value) => setAttributes({ color: value.hex })
                })
            ),
            createElement("div", { className: "form-group" },
                createElement("label", { htmlFor: "button_color" }, "Choose Button Color"),
                createElement(wp.components.ColorPicker, {
                    color: button_color,
                    onChangeComplete: (value) => setAttributes({ button_color: value.hex })
                })
            ),
            createElement("div", { className: "form-group" },
                createElement("label", { htmlFor: "streak_connection_color" }, "Choose Streak Connection Color"),
                createElement(wp.components.ColorPicker, {
                    color: streak_connection_color,
                    onChangeComplete: (value) => setAttributes({ streak_connection_color: value.hex })
                })
            ),
            createElement("div", { className: "form-group" },
                createElement("label", { htmlFor: "today_color" }, "Choose Today Color"),
                createElement(wp.components.ColorPicker, {
                    color: today_color,
                    onChangeComplete: (value) => setAttributes({ today_color: value.hex })
                })
            ),
            createElement("div", { className: "form-group" },
                createElement("label", { htmlFor: "class_name" }, "Enter Class"),
                createElement("input", {
                    type: "text",
                    id: "class_name",
                    placeholder: "Enter Class",
                    value: class_name,
                    onChange: (input) => setAttributes({ class_name: input.target.value })
                })
            ),
        );
    }

   registerBlockType('pbd-streaks/streaks-block', {
        title: 'Streaks Block',
        icon: 'calendar',
        category: 'common',

        attributes: {
            id: {
                type: 'number',
            },
            count: {
                type: 'number',
                default: 1,
            },
            color: {
                type: 'string',
                default: '#24D8A2',
            },
            button_color: {
                type: 'string',
            },
            streak_connection_color: {
                type: 'string',
            },
            class_name: {
                type: 'string',
            },
            timezone: {
                type: 'string',
            },
            today_color: {
                type: 'string',
            },
        },

        edit: edit,

        save: function () {
            return null; // The block will be rendered on the PHP side using `render_callback`
        },
    });

})(window.wp.blocks, window.wp.element);