import PropTypes from "prop-types";

const AsSlot = ({ slot }) => {
  return <div dangerouslySetInnerHTML={{ __html: slot }}></div>;
};

export default function Example({ node, slots }) {
  // const { node, test } = props;
  // console.log("props", props.test);
  console.log("node", node);
  console.log("slots", slots);
  return (
    <>
      <h4>(Loaded via inertia)</h4>
      <AsSlot slot={node.field_image} />
      {slots}
      <AsSlot slot={node.body} />
      <AsSlot slot={node.field_tags} />
      <AsSlot slot={node.comment} />
    </>
  );
}

Example.propTypes = {
  slots: PropTypes.node,
  node: PropTypes.shape({
    body: PropTypes.string.isRequired,
    field_image: PropTypes.string,
    field_tags: PropTypes.string,
    comment: PropTypes.string,
  }),
};

AsSlot.propTypes = {
  slot: PropTypes.node,
};
